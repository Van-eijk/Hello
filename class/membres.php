<?php

    class Membres{
        private $IdMembre ;
        private $pseudoMembre;
        private $emailMembre;
        private $motDePasseMembre;
        private $dateCreationMembre;
        private $statut;
        private $derniereConnexion ;




         // METHODES


        public function afficherListeMembre($lienFichierBDD){
            include $lienFichierBDD ;
            $reqListeMembre = $connexionDataBase->prepare("SELECT * FROM membres ORDER BY pseudoMembre") ;
            $reqListeMembre->execute() ;

            if($reqListeMembre ->rowCount() >= 1){
            
                    $resultatAfficherMembre = $reqListeMembre->fetchAll(PDO::FETCH_ASSOC) ;
                    return $resultatAfficherMembre ;
                    
            }
            else{
                    return false ;
            }


        }


        public function deconnexionMembre($idMembre, $lienFichierBDD){
            // On change d'abord le statut de l'utilisateur dans la base de données avant la déconnexion


            include $lienFichierBDD ;

            $statut = "hors ligne";
            
            $date = date("Y-m-d H:i:s") ; // format de date de mysql
            
            $reqMembre = $connexionDataBase -> prepare('UPDATE membres SET statut = :statut, derniereConnexion = :derniereC WHERE idMembre = :idMembre');
            $reqMembre ->execute(array(
                'statut' => $statut,
                'derniereC' => $date,
                'idMembre' => $idMembre
            ));

            if($reqMembre->rowCount() >= 1){
                //return true ;

                session_start();

                $_SESSION = array();
                $_SESSION = array();
                session_destroy();
       
            }
            

            
            

        }

        public function inscriptionMembre($pseudoMembre, $emailMembre, $motDePasseMembre, $lienFichierBDD){
            include $lienFichierBDD ;

            $mdpHash = password_hash($motDePasseMembre, PASSWORD_DEFAULT) ; // hachage du mot de passe
            $statut = "hors ligne";
            
            $reqMembre = $connexionDataBase -> prepare('INSERT INTO membres(pseudoMembre,emailMembre,motDePasseMembre,statut) VALUES (:pseudo, :email, :motdepasse, :statut)');
            $reqMembre ->execute(array(
                'pseudo' => $pseudoMembre,
                'email' => $emailMembre,
                'motdepasse' => $mdpHash,
                'statut' => $statut

            ));

            if($reqMembre->rowCount() >= 1){
                return true ;
       
            }
            else{
                return false ;
               
            }

        }

        public function connexionMembre($pseudoMembre, $motDePasseMembre, $lienFichierBDD){
            //echo("bobo");
            include $lienFichierBDD ;

            $reqConnexionAdmin = $connexionDataBase->prepare("SELECT * FROM membres WHERE pseudoMembre = :pseudo") ;
            $reqConnexionAdmin->execute(array(
                'pseudo'=>$pseudoMembre
            )) ;

            $resultatConnexionAdmin = $reqConnexionAdmin->fetch();
            //echo $resultatConnexionAdmin['typeAdmin'] ;

            if(!$resultatConnexionAdmin){
                return false;
            }
            else{
                if(password_verify($motDePasseMembre, $resultatConnexionAdmin['motDePasseMembre'])){

                    // On cree les variables de session
                    session_start();
                    $_SESSION['emailMembre'] = $resultatConnexionAdmin['emailMembre'];
                    $_SESSION['idMembre'] = $resultatConnexionAdmin['idMembre'];
                    $_SESSION['pseudoMembre'] = $resultatConnexionAdmin['pseudoMembre'];


                    // On modifie le statut de l'utilisateur en base de données


                    $statut = "en ligne";
                    
            
                    $reqMembre = $connexionDataBase -> prepare('UPDATE membres SET statut = :statut WHERE pseudoMembre = :pseudoMembre');
                    $reqMembre ->execute(array(
                        'statut' => $statut,
                        
                        'pseudoMembre' => $pseudoMembre
                    ));

                    if($reqMembre->rowCount() >= 1){
                        return true ;
            
                    }

                }
                else{
                    return false;
                }

            }

        }
    }
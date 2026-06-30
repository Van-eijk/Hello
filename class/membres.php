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

        /** Fonction pour charger les anciens messages */

        public function loadOldMessageInbox($lienFichierBDD, $firstId, $intervalle){
            include $lienFichierBDD;

            $reqOldMessage = $connexionDataBase->prepare("SELECT * FROM messageinbox WHERE idMessageInbox <= :firstId AND idMessageInbox >= :intervalleMessage ORDER BY idMessageInbox DESC");
            $reqOldMessage->execute(array(
                "firstId" => $firstId,
                "intervalleMessage" => $intervalle


            ));

            if($reqOldMessage->rowCount() >= 1){
                $resultatreqOldMessage = $reqOldMessage->fetchAll(PDO::FETCH_ASSOC) ;
                return $resultatreqOldMessage;
            }
            else{
                return false;
            }
        }

        public function loadMessageInbox($lienFichierBDD, $idSender, $idReceiver){
            include $lienFichierBDD ;

            //$identifiants = array() ;

            $reqListeMessage = $connexionDataBase->prepare("SELECT * FROM (SELECT * FROM messageinbox WHERE (idMembreExpediteur = :idSender AND idMembreDestinataire = :idReceiver) OR (idMembreExpediteur = :idReceiver AND idMembreDestinataire = :idSender) ORDER BY datemessage DESC LIMIT 5 ) AS sous_requete ORDER BY idMessageInbox ASC ") ;
            $reqListeMessage->execute(array(
                "idSender" => $idSender,
                "idReceiver" => $idReceiver
            )) ;


            if($reqListeMessage->rowCount() >= 1){
                $resultatReqListeMessage = $reqListeMessage->fetchAll(PDO::FETCH_ASSOC) ;

                
                return $resultatReqListeMessage;
               
            }
            else{
                return false;
            }

        }

        public function loadInfoReceiver($lienFichierBDD, $id){
            include $lienFichierBDD ;
            $reqInfoMembre = $connexionDataBase->prepare("SELECT pseudoMembre, statut, derniereConnexion FROM membres WHERE idMembre = :id") ;
            $reqInfoMembre->execute(array(
                "id" => $id
            )) ;

            if($reqInfoMembre ->rowCount() >= 1){
            
                $resultatAfficherMembre = $reqInfoMembre->fetch() ;
                return $resultatAfficherMembre ;
                    
            }
            else{
                return false ;
            }

        }


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
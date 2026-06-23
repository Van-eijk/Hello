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


        public function deconnexionMembre($lien){
             session_start();
            $_SESSION = array();
            $_SESSION = array();
            session_destroy();
            header($lien);

        }

        public function inscriptionMembre($pseudoMembre, $emailMembre, $motDePasseMembre, $lienFichierBDD){
            //setPseudo($pseudo);
            include $lienFichierBDD ;

            $mdpHash = password_hash($motDePasseMembre, PASSWORD_DEFAULT) ; // hachage du mot de passe
            $statut = "en ligne";
            
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

        public function connexionMembre($pseudoMembre, $motDePasseMembre, $lienFichierBDD, $lienPageAccueil){
            //echo("bobo");
            include $lienFichierBDD ;

            $reqConnexionAdmin = $connexionDataBase->prepare("SELECT * FROM membres WHERE pseudoMembre = :pseudo") ;
            $reqConnexionAdmin->execute(array(
                    'emailAdmin'=>$emailAdmin
            )) ;

            $resultatConnexionAdmin = $reqConnexionAdmin->fetch();
            //echo $resultatConnexionAdmin['typeAdmin'] ;

            if(!$resultatConnexionAdmin){
                return false;
            }
            else{
                if(password_verify($motDePasseMembre, $resultatConnexionAdmin['motDePasseMembre'])){
                    session_start();
                    $_SESSION['emailMembre'] = $resultatConnexionAdmin['emailMembre'];
                    $_SESSION['idMembre'] = $resultatConnexionAdmin['idMembre'];
                    $_SESSION['pseudoMembre'] = $resultatConnexionAdmin['pseudoMembre'];

                   
                    //echo $resultatConnexionAdmin['nomAdmin'] ;

                    header("Location:$lienPageAccueil");
                }else{
                    return false;
                }

            }

        }
    }
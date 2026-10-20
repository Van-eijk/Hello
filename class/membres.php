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

        /** Fonction pour retirer le membre dans l'inbox*/

        public function retirerMembreInbox(string $lienFichierBDD, int $idSender){
            include $lienFichierBDD ;

            $reqRetirerMembreInbox = $connexionDataBase->prepare("SELECT idMembreExpediteurInbox FROM presenceinbox WHERE idMembreExpediteurInbox = :idSender OR idMembreDestinataireInbox = :idSender") ;
            $reqRetirerMembreInbox->execute(array(
                "idSender" => $idSender
            )) ;

            if($reqRetirerMembreInbox->rowCount() >= 1){
                $resultatReqRetirerMembreInbox = $reqRetirerMembreInbox->fetch() ;
                if($resultatReqRetirerMembreInbox['idMembreExpediteurInbox'] == $idSender){
                    $reqSupprimerMembreInbox = $connexionDataBase->prepare("UPDATE presenceinbox SET idMembreExpediteurInbox = NULL WHERE idMembreExpediteurInbox = :idSender") ;
                    $reqSupprimerMembreInbox->execute(array(
                        "idSender" => $idSender
                    )) ;
                }
                else{
                    $reqSupprimerMembreInbox = $connexionDataBase->prepare("UPDATE presenceinbox SET idMembreDestinataireInbox = NULL WHERE idMembreDestinataireInbox = :idSender") ;
                    $reqSupprimerMembreInbox->execute(array(
                        "idSender" => $idSender
                    )) ;
                }

                // On supprime les lignes où les deux colonnes sont NULL
                $reqSupprimerLignesNull = $connexionDataBase->prepare("DELETE FROM presenceinbox WHERE idMembreExpediteurInbox IS NULL AND idMembreDestinataireInbox IS NULL") ;
                $reqSupprimerLignesNull->execute() ;

                
                

                return true ;
            }
            else{
                return false ;
            }
        }

        /** Fonction pour verifier la presence dans l'inbox  */

        public function verificationPresenceInbox(string $lienFichierBDD, int $idSender, int $idReceiver){
            include $lienFichierBDD ;

            //On verifie si le membre B est deja present dans la table presenceinbox comme destinataire ou expediteur,

            $reqVerificationPresenceInbox = $connexionDataBase->prepare("SELECT * FROM presenceinbox WHERE (idMembreExpediteurInbox = :idReceiver) OR (idMembreDestinataireInbox = :idReceiver)") ;
            $reqVerificationPresenceInbox->execute(array(
                
                "idReceiver" => $idReceiver
            )) ;

            if($reqVerificationPresenceInbox->rowCount() >= 1){
                $resultatReqVerificationPresenceInbox = $reqVerificationPresenceInbox->fetchAll(PDO::FETCH_ASSOC) ;

                if($resultatReqVerificationPresenceInbox[0]['idMembreExpediteurInbox'] == $idReceiver){
                    //Si le membre B est present dans la table presenceinbox comme expediteur, on ajoute le membre A comme destinataire
                    $reqAjouterDestinataire = $connexionDataBase->prepare("UPDATE presenceinbox SET idMembreDestinataireInbox = :idSender WHERE idMembreExpediteurInbox = :idReceiver") ;
                    $reqAjouterDestinataire->execute(array(
                        "idSender" => $idSender,
                        "idReceiver" => $idReceiver
                    )) ;
                }
                else{
                    //Si le membre B est present dans la table presenceinbox comme destinataire, on ajoute le membre A comme expediteur
                    $reqAjouterExpediteur = $connexionDataBase->prepare("UPDATE presenceinbox SET idMembreExpediteurInbox = :idSender WHERE idMembreDestinataireInbox = :idReceiver") ;
                    $reqAjouterExpediteur->execute(array(
                        "idSender" => $idSender,
                        "idReceiver" => $idReceiver
                    )) ;
                }
                return true ;
            }
            else{
                //Au cas où le membre B n'est pas present dans la table presenceinbox, on ajoute le membre A comme expediteur
                $reqAjouterPresenceInbox = $connexionDataBase->prepare("INSERT INTO presenceinbox(idMembreExpediteurInbox) VALUES(:idSender)") ;
                $reqAjouterPresenceInbox->execute(array(
                    "idSender" => $idSender,
                    
                )) ;

                return true ;
            }
        }

        /** Fonction pour confirmer la lecture d'un message */

        public function confirmReadMessage(string $lienFichierBDD, int $idMessageInbox, int $idMembreExpediteur, int $idMembreDestinataire): bool {
            include $lienFichierBDD ;

            $reqConfirmReadMessage = $connexionDataBase->prepare("UPDATE messageinbox SET vueMessage = :vueMessage WHERE ((idMembreExpediteur = :idMembreExpediteur AND idMembreDestinataire = :idMembreDestinataire) OR (idMembreExpediteur = :idMembreDestinataire AND idMembreDestinataire = :idMembreExpediteur)) AND idMessageInbox <= :idMessageInbox") ;
            $reqConfirmReadMessage->execute(array(
                "vueMessage" => "TRUE",
                "idMessageInbox" => $idMessageInbox,
                "idMembreExpediteur" => $idMembreExpediteur,
                "idMembreDestinataire" => $idMembreDestinataire
            )) ;

            if($reqConfirmReadMessage->rowCount() >= 1){
                return true ;
            }
            else{
                return false ;
            }
        }

        /** Fonction Pour mettre jour la liste des discussions automatiquement */

        public function getNewDiscussions(string $lienFichierBDD, int $idMembre, int $lastIdMessage){
            include $lienFichierBDD ;

            $reqNewDiscussion = $connexionDataBase->prepare("SELECT message.idMessageInbox as idMessageInbox, expediteur.pseudoMembre AS sender, destinataire.pseudoMembre AS receiver, message.idMembreExpediteur, message.idMembreDestinataire, message.messagetext, message.datemessage FROM membres AS expediteur INNER JOIN messageinbox AS message ON message.idMembreExpediteur = expediteur.idMembre INNER JOIN membres AS destinataire ON idMembreDestinataire = destinataire.idMembre WHERE (idMembreExpediteur = :idMembre OR idMembreDestinataire = :idMembre) AND message.idMessageInbox > :lastIdMessage ORDER BY datemessage DESC LIMIT 1 OFFSET 0") ;
            $reqNewDiscussion->execute(array(
                "idMembre" => $idMembre,
                "lastIdMessage" => $lastIdMessage
            ));

            if($reqNewDiscussion->rowCount() >= 1){
                $resultatReqNewDiscussion = $reqNewDiscussion->fetchAll(PDO::FETCH_ASSOC) ;
                return $resultatReqNewDiscussion;
            }
            else{
                return false;
            }
        }

        /** Fonction pour afficher les discussions recentes en inbox */

        public function afficherDiscussionInbox(string $lienFichierBDD, int $idMembre){
            include $lienFichierBDD ;

            $reqDiscussionInbox = $connexionDataBase->prepare("SELECT message.idMessageInbox as idMessageInbox, expediteur.pseudoMembre AS sender, destinataire.pseudoMembre AS receiver, message.idMembreExpediteur, message.idMembreDestinataire, message.messagetext, message.datemessage FROM membres AS expediteur INNER JOIN messageinbox AS message ON message.idMembreExpediteur = expediteur.idMembre INNER JOIN membres AS destinataire ON idMembreDestinataire = destinataire.idMembre WHERE (idMembreExpediteur = :idMembre OR idMembreDestinataire = :idMembre) ORDER BY datemessage DESC ") ;
            $reqDiscussionInbox->execute(array(
                "idMembre" => $idMembre
            )) ;

            if($reqDiscussionInbox->rowCount() >= 1){
                $resultatReqDiscussionInbox = $reqDiscussionInbox->fetchAll(PDO::FETCH_ASSOC) ;
                return $resultatReqDiscussionInbox;
            }
            else{
                return false;
            }
        }

        /** Fonction pour récupérer les nouveaux messages */
        public function getNewMessages(int $idSender, int $idReceiver, int $lastIdMessage){
            include 'database/configdatabase.php';

            $reqNewMessage = $connexionDataBase->prepare("SELECT * FROM messageinbox WHERE ((idMembreExpediteur = :idSender AND idMembreDestinataire = :idReceiver) OR (idMembreExpediteur = :idReceiver AND idMembreDestinataire = :idSender)) AND idMessageInbox > :lastIdMessage ORDER BY idMessageInbox ASC");
            $reqNewMessage->execute(array(
                "idSender" => $idSender,
                "idReceiver" => $idReceiver,
                "lastIdMessage" => $lastIdMessage
            ));

            if($reqNewMessage->rowCount() >= 1){
                $resultatReqNewMessage = $reqNewMessage->fetchAll(PDO::FETCH_ASSOC) ;
                return $resultatReqNewMessage;
            }
            else{
                return false;
            }
        }

        /** Fonction pour envoyer un message inbox */

        public function sendMessageInbox(string $lienFichierBDD, int $idSender, int $idReceiver, string $messageText){
            include $lienFichierBDD;

            $reqSendMessageInbox = $connexionDataBase->prepare('INSERT INTO messageinbox(idMembreExpediteur,idMembreDestinataire,messagetext) VALUES(:idSender,:idReceiver,:messageText)');
            $reqSendMessageInbox->execute(array(
                "idSender" => $idSender,
                "idReceiver" => $idReceiver,
                "messageText" => $messageText
            ));

            if($reqSendMessageInbox->rowCount() >= 1){
                return true;
            }
            else{
                return false ;
            }
        }

        /** Fonction pour charger les anciens messages */

        public function loadOldMessageInbox(string $lienFichierBDD, int $firstId, int $idSender, int $idReceiver){
            include $lienFichierBDD;

            $reqOldMessage = $connexionDataBase->prepare("SELECT * FROM messageinbox WHERE ((idMembreExpediteur = :idSender AND idMembreDestinataire = :idReceiver) OR (idMembreExpediteur = :idReceiver AND idMembreDestinataire = :idSender)) AND (idMessageInbox < :firstId) ORDER BY idMessageInbox DESC LIMIT 3");
            $reqOldMessage->execute(array(
                "idSender" => $idSender,
                "idReceiver" => $idReceiver,
                "firstId" => $firstId,
                
            ));

            if($reqOldMessage->rowCount() >= 1){
                $resultatreqOldMessage = $reqOldMessage->fetchAll(PDO::FETCH_ASSOC) ;
                return $resultatreqOldMessage;
            }
            else{
                return false;
            }
        }

        public function loadMessageInbox(string $lienFichierBDD, int $idSender, int $idReceiver){
            include $lienFichierBDD ;

            //$identifiants = array() ;

            $reqListeMessage = $connexionDataBase->prepare("SELECT * FROM (SELECT * FROM messageinbox WHERE (idMembreExpediteur = :idSender AND idMembreDestinataire = :idReceiver) OR (idMembreExpediteur = :idReceiver AND idMembreDestinataire = :idSender) ORDER BY datemessage DESC LIMIT 10 ) AS sous_requete ORDER BY idMessageInbox ASC ") ;
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

        public function loadInfoReceiver(string $lienFichierBDD, int $id){
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


        public function afficherListeMembre(string $lienFichierBDD){
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


        public function deconnexionMembre(int $idMembre, string $lienFichierBDD){
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

        public function inscriptionMembre(string $pseudoMembre, string $emailMembre, string $motDePasseMembre, string $lienFichierBDD){
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

        public function connexionMembre(string $pseudoMembre, string $motDePasseMembre, string $lienFichierBDD){
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
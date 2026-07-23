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

        /** Fonction Pour mettre jour la liste des discussions automatiquement */

        public function getNewDiscussions($lienFichierBDD, $idMembre, $lastIdMessage){
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

        public function afficherDiscussionInbox($lienFichierBDD, $idMembre){
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
        public function getNewMessages($idSender, $idReceiver, $lastIdMessage){
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

        public function sendMessageInbox($lienFichierBDD, $idSender, $idReceiver, $messageText){
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

        public function loadOldMessageInbox($lienFichierBDD, $firstId, $idSender, $idReceiver){
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
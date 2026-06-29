<?php
    include 'class/uploadclass.php';
    include 'database/configdatabase.php';
    $lienFichierBDD = "database/configdatabase.php";

    if(isset($_GET['idSenderAjax'])){
        if(isset($_GET['idReceiverAjax'])){
            $membre = new Membres();
            $idSender = $_GET['idSenderAjax'];
            $idReceiver = $_GET['idReceiverAjax'] ;
            $identifiants = array();

            $listeMessage = $membre->loadMessageInbox($lienFichierBDD,$idSender,$idReceiver);

            if($listeMessage == false){
                echo json_encode([
                    "status" => "erreur",
                    "message" => "Aucun message, Débutez la conversation en envoyant un coucou..."
                ]);
            }else{
                foreach($listeMessage as $message){
                    array_push($identifiants,$message['idMessageInbox']);
                }

                echo json_encode([
                    "status" => "success",
                    "listeMessage" => $listeMessage,
                    "lastMessage" => $identifiants[0]
                ]);

            }
        
        }else{
            echo json_encode([
                "status" => "erreur",
                "message" => "Identifiant du destinataire manquant !"
               
            ]);
        }

    }else{
        echo json_encode([
            "status" => "erreur",
            "message" => "Identifiant de l'expediteur manquant !",
            
        ]);
    }
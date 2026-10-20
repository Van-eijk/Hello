<?php
    include 'class/uploadclass.php';
    include 'database/configdatabase.php';
    $lienFichierBDD = "database/configdatabase.php";

    if(isset($_GET['idSenderAjax'])){
        if(isset($_GET['idReceiverAjax'])){
            if(isset($_GET['contenuMessage'])){
                $membre = new Membres();
                $idSender = $_GET['idSenderAjax'] ;
                $idReceiver = $_GET['idReceiverAjax'] ;
                $messageText = $_GET['contenuMessage'] ;


                $sendMessage = $membre->sendMessageInbox($lienFichierBDD, $idSender, $idReceiver, $messageText) ;

                if($sendMessage){
                    echo json_encode([
                        "status" => "success",
                        "message" => "Message envoyé avec succès"
                    ]);
                }else{
                    echo json_encode([
                        "status" => "error",
                        "message" => "Echec" 
                    ]);

                }
        
            }
        
        }

    }
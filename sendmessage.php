<?php
    include 'class/uploadclass.php';
    include 'database/configdatabase.php';
    $lienFichierBDD = "database/configdatabase.php";

    if(isset($_POST['idSenderAjax'])){
        if(isset($_POST['idReceiverAjax'])){
            if(isset($_POST['contenuMessage'])){
                $membre = new Membres();
                $idSender = $_POST['idSenderAjax'] ;
                $idReceiver = $_POST['idReceiverAjax'] ;
                $messageText = $_POST['contenuMessage'] ;


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
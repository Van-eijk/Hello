<?php
    include 'class/uploadclass.php';
    include 'database/configdatabase.php';
    $lienFichierBDD = "database/configdatabase.php";
    if(isset($_GET['firstIdAjax'])){

        if(isset($_GET['idSenderAjax'])){

            if(isset($_GET['idReceiverAjax'])){

                $firstId = $_GET['firstIdAjax'] ;
                $intervalleMessage = $firstId - 2 ;
                $idSender = $_GET['idSenderAjax'] ;
                $idReceiver = $_GET['idReceiverAjax'] ;
                $oldId = array();
                $membre = new Membres();


                $ancienMessage = $membre->loadOldMessageInbox($lienFichierBDD, $firstId, $idSender, $idReceiver);

                if($ancienMessage == false){
                    echo json_encode([
                        "status" => "error",
                        "message" => "Aucun message"

                    ]);
                }else{

                    foreach($ancienMessage as $message){
                        array_push($oldId,$message['idMessageInbox']);
                    }
                    echo json_encode([
                        "status" => "success",
                        "oldMessage" => $ancienMessage,
                        "newFirstId" => end($oldId)

                    ]);

                }
                
            }else{
                echo json_encode([
                    "status" => "error",
                    "message" => "Identifiant du destinataire manquant !"
                ]);
            
            }

        }else{
            echo json_encode([
                "status" => "error",
                "message" => "Identifiant de l'expediteur manquant !"
            ]);
        }
    }
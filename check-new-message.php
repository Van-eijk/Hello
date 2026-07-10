<?php
    include 'class/uploadclass.php';
    include 'database/configdatabase.php';
    $lienFichierBDD = "database/configdatabase.php";

    if(isset($_GET['idSenderAjax'])){
        if(isset($_GET['idReceiverAjax'])){
            if(isset($_GET['lastIdMessageAjax'])){
                $membre = new Membres();
                $idSender = $_GET['idSenderAjax'] ;
                $idReceiver = $_GET['idReceiverAjax'] ;
                $lastIdMessage = $_GET['lastIdMessageAjax'] ;
                $newMessages = $membre->getNewMessages($idSender, $idReceiver, $lastIdMessage);
                if($newMessages == false){
                    echo json_encode([
                        "status" => "error",
                        "message" => "Aucun nouveau message"
                    ]);
                }else{
                    echo json_encode([
                        "status" => "success",
                        "newMessages" => $newMessages
                    ]);
                }
                    
                

            }else{
                echo json_encode([
                    "status" => "error",
                    "message" => "Identifiant du dernier message manquant !"
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
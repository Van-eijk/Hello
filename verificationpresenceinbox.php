<?php
    include 'class/uploadclass.php';
    include 'database/configdatabase.php';
    $lienFichierBDD = "database/configdatabase.php";

    if(isset($_GET['idSenderAjax'])){
        if(isset($_GET['idReceiverAjax'])){
            $membre = new Membres();
            $idSender = $_GET['idSenderAjax'];
            $idReceiver = $_GET['idReceiverAjax'] ;

            $presenceInbox = $membre->verificationPresenceInbox($lienFichierBDD,$idSender,$idReceiver);

            if($presenceInbox == true){
                echo json_encode([
                    "status" => "success",
                    "message" => "Insertion reussie !"
                ]);
            } 
        }
    }
           
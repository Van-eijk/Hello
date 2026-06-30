<?php
    include 'class/uploadclass.php';
    include 'database/configdatabase.php';
    $lienFichierBDD = "database/configdatabase.php";
    if(isset($_GET['firstIdAjax'])){
        $firstId = $_GET['firstIdAjax'] ;
        $intervalleMessage = $firstId - 2 ;
        $oldId = array();
        $membre = new Membres();


        $ancienMessage = $membre->loadOldMessageInbox($lienFichierBDD, $firstId, $intervalleMessage);

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
    }
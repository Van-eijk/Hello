<?php

    include 'class/uploadclass.php';
    include 'database/configdatabase.php';
    $lienFichierBDD = "database/configdatabase.php";
    include $lienFichierBDD;
    $messageId = array();

    if(!isset($_GET['idMembreAjax'])) {
        header('Location: index.php');
        exit();
    }else{
        $idMembre = $_GET['idMembreAjax'];

        $membre = new Membres();
        $discussionsInbox = $membre->afficherDiscussionInbox($lienFichierBDD, $idMembre);

        if($discussionsInbox == false){
            echo json_encode([
                "status" => "error",
                "message" => "Aucune discussion récente"
            ]);
        }else{

           
            echo json_encode([
                "status" => "success",
                "discussionsInbox" => $discussionsInbox
            ]);
        }

    }
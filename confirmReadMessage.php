<?php
    include 'class/uploadclass.php';
    include 'database/configdatabase.php';
    $lienFichierBDD = "database/configdatabase.php";

    $membre = new Membres();

    if(isset($_GET['idMembreExpediteurAjax']) && isset($_GET['idMembreDestinataireAjax']) && isset($_GET['idMessageInboxAjax'])){
        $idMembreExpediteur = $_GET['idMembreExpediteurAjax'] ;
        $idMembreDestinataire = $_GET['idMembreDestinataireAjax'] ;
        $idMessageInbox = $_GET['idMessageInboxAjax'] ;
        $confirmReadMessage = $membre->confirmReadMessage($lienFichierBDD,$idMessageInbox, $idMembreExpediteur, $idMembreDestinataire);
        if($confirmReadMessage == false){
            echo json_encode([
                "status" => "error",
                "message" => "Erreur lors de la confirmation de lecture du message"
            ]);
        }else{
            echo json_encode([
                "status" => "success",
                "message" => "Lecture du message confirmée"
            ]);
        }
    }else{
        echo json_encode([
            "status" => "error",
            "message" => "Identifiants manquants !"
        ]);
    }

   
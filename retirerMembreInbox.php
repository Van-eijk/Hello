<?php
     include 'class/uploadclass.php';
    include 'database/configdatabase.php';
    $lienFichierBDD = "database/configdatabase.php";

    $membre = new Membres();

    if (isset($_GET['idSenderAjax'])) {
        $idSender = $_GET['idSenderAjax'];
        $remove = $membre->retirerMembreInbox($lienFichierBDD,$idSender);

        if ($remove) {
            echo json_encode([
                "status" => "success",
                "message" => "Membre retiré avec succès."
            ]);
        } else {
            echo json_encode([
                "status" => "erreur",
                "message" => "Erreur lors du retrait du membre."
            ]);
        }   
    }
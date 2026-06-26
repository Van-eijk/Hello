<?php

    include 'class/uploadclass.php';
    include 'database/configdatabase.php';
    $lienFichierBDD = "database/configdatabase.php";


    $membre = new Membres();

    $listeMembre = $membre->afficherListeMembre($lienFichierBDD) ;

    if($listeMembre == false){
        echo json_encode([
            "status" => "erreur",
            "message" => "Aucun membre"
        ]);

    }
    else{
        echo json_encode([
            "status" => "success",
            "message" => "presence des membres",
            "listeDesMembres" => $listeMembre

        ]);

    }


   

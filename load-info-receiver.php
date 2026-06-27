<?php
    include 'class/uploadclass.php';
    include 'database/configdatabase.php';
    $lienFichierBDD = "database/configdatabase.php";


   if(isset($_GET['idAjax'])){

        $membre = new Membres();
        $id = $_GET['idAjax'] ;

        $infoMembre = $membre->loadInfoReceiver($lienFichierBDD, $id) ;

        if($infoMembre == false){
            echo json_encode([
                "status" => "erreur",
                "message" => "Aucun membre"
            ]);

        }
        else{
            echo json_encode([
                "status" => "success",
                "message" => "presence des informations",
                "infoMembres" => $infoMembre

            ]);

        }
   }else{
        echo json_encode([
            "status" => "error",
            "message" => "Identifiant manquant",
           

        ]);
   }
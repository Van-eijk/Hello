<?php
    include 'class/uploadclass.php';
    include 'database/configdatabase.php';
    $lienFichierBDD = "database/configdatabase.php";

    $membre = new Membres();

    if(isset($_GET['idMembreAjax'])){
        if(isset($_GET['lastIdMessageAjax'])){
            $idMembre = $_GET['idMembreAjax'] ;
            $lastIdMessage = $_GET['lastIdMessageAjax'] ;
            $newDiscussions = $membre->getNewDiscussions($lienFichierBDD, $idMembre, $lastIdMessage);
            if($newDiscussions == false){
                echo json_encode([
                    "status" => "error",
                    "message" => "Aucune nouvelle discussion"
                ]);
            }else{
                echo json_encode([
                    "status" => "success",
                    "newDiscussions" => $newDiscussions
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
            "message" => "Identifiant du membre manquant !"
        ]);
    }
<?php

    include 'class/uploadclass.php';
    include 'database/configdatabase.php';
    $lienFichierBDD = "database/configdatabase.php";

    if(isset($_POST["pseudoAjax"])){
        if(isset($_POST["emailAjax"])){
            if(isset($_POST["passwordAjax"])){
                $membre = new Membres();

                $pseudoMembre = $_POST["pseudoAjax"] ;
                $emailMembre = $_POST["emailAjax"] ;
                $motDePasseMembre = $_POST["passwordAjax"] ;

                $inscription = $membre->inscriptionMembre($pseudoMembre, $emailMembre, $motDePasseMembre, $lienFichierBDD);

                if($inscription){

                    echo json_encode([
                        "status" => "success",
                        "message" => "Inscription réussie"
                    ]);

                }else{

                    echo json_encode([
                        "status" => "erreur",
                        "message" => "Une erreure s'est produite lors de l'insertion des données dans la BD"
                    ]);

                }
        
            }

        
        }


    }

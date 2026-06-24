<?php

    include 'class/uploadclass.php';
    include 'database/configdatabase.php';
    $lienFichierBDD = "database/configdatabase.php";
   

    if(isset($_POST["pseudoAjax"])){
        
        if(isset($_POST["passwordAjax"])){
            $membre = new Membres();

            $pseudoMembre = $_POST["pseudoAjax"] ;
            $motDePasseMembre = $_POST["passwordAjax"] ;

            

            $connexion = $membre->connexionMembre($pseudoMembre, $motDePasseMembre, $lienFichierBDD);

            if($connexion === false){

                echo json_encode([
                    "status" => "erreur",
                    "message" => "Pseudo ou mot de passe incorrect"
                ]);

            }else{

                echo json_encode([
                    "status" => "success",
                    "message" => "Connexion reussie"
                ]);

            }
    
        }

        
        


    }

<?php
    include 'class/uploadclass.php';
    include 'database/configdatabase.php';
    $lienFichierBDD = "database/configdatabase.php";

    $membre = new Membres();


     $listeMembre = $membre->afficherListeMembre($lienFichierBDD) ;

    if($listeMembre == false){
        echo "aucun membre" ;

    }
    else{
        echo "ok" ;

    }

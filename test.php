<?php
    include 'class/uploadclass.php';
    include 'database/configdatabase.php';
    $lienFichierBDD = "database/configdatabase.php";

    $membre = new Membres();
    $idSender = 6;
    $idReceiver = 8 ;


    $listeMessage = $membre->loadMessageInbox($lienFichierBDD,$idSender ,$idReceiver );

    if($listeMessage == false){
        echo "aucun membre" ;

    }
    else{
        foreach($listeMessage as $itemMessage){
            echo $itemMessage['messagetext'];
        }

    }

<?php

    session_start();

    include 'class/uploadclass.php';
    include 'database/configdatabase.php';
    $lienFichierBDD = "database/configdatabase.php";

    $membre = new Membres();
    $lien = "Location:index.php";

    $membre->deconnexionMembre($_SESSION['idMembre'],$lienFichierBDD);
    header($lien);


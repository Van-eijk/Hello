<?php

    include 'class/uploadclass.php';
    include 'database/configdatabase.php';
    $lienFichierBDD = "database/configdatabase.php";

    $membre = new Membres();
    $lien = "Location:index.php";

    $membre->deconnexionMembre();
    header($lien);


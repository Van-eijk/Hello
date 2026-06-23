<?php 
    $hostName = "localhost";
    $dbName = "hellodb";
    $username = "root";
    $password = "root";





    try{
        $connexionDataBase = new PDO("mysql:host=$hostName;dbname=$dbName;charset=utf8mb4", $username, $password ,array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"));
        // Le dernier argument permet de récupérer les érreurs liées à la base de données MySql
    }
    catch(Exception $e){
        echo ("Erreur : $e -> getMessage() ");
    }
    
?>
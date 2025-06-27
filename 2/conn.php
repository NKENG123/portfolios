<?php

$server = "localhost";
$user = "root";
$dbname = "document";
$password = "";
try{
    $conn = new PDO("mysql:host=$server; dbname=$dbname", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
    die("Erreur de connexion : " . $e->getMessage());
    }
   ?>
    
   
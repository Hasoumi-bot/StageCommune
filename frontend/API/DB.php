<?php
try{
$pdo = new PDO("pgsql:host=localhost;port=5432;dbname=To_Do_db",
 "postgres",
 "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   }
catch(PDOException $e){
    die("Erreur de connexion : " . $e->getMessage());
}
?>
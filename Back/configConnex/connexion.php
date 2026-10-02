<?php

try{
    $DB = new PDO(
        "mysql:host=localhost;dbname=gestioncyclocua2026;
         charset=utf8",
         "root",
         ""
    );
    
    $DB->setAttribue(
        PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION
    );
}
catch(PDOException $e) {
    die("Erreur:" . $e->getMessage());
}
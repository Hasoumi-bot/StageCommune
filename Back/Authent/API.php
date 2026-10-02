<?php
include("configuration.php");
include("connexion.php");

header("Access-Control-Allow-Origin: *");
header("Content-type: application/json");
header("Access-Control-Allow-Methods: GET,POST");
header("Access-Control-Allow-Headers: Content-Type, AUthorization");


$login = new login($DB);

$donnees = json_decode(file_get_contents("php://input"),true);

$action = $donnees["action"] ?? "";

$methode = $_SERVER["REQUEST_METHOD"];

if ($methode == 'POST'){
    if($action == "connexion"){
        $email = $donnees["email" ?? ""]
        $motDePasse = $donnees["motDePasse" ?? ""]

        if(empty($email) || empty($motDePasse)){

        echo json_encode([
            "success" => false,
            "message" => "Email et mot de passe obligatoires"
        ]);
        exit;
        }

            $result = $login->connecter($email,$motDePasse);

            echo json_encode($result);
        }
    }

}
<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") { http_response_code(204);
    exit;
}

include_once(__DIR__ . "/../configConnex/connexion.php");
include_once(__DIR__ . "/login.php");

$login = new login($DB);


$donnees = json_decode(file_get_contents("php://input"), true) ?? [];
$action  = $donnees["action"] ?? "";
$methode = $_SERVER["REQUEST_METHOD"];

if ($methode !== "POST") {
    http_response_code(405);
    echo json_encode(["success" => false, "message" => "Méthode non autorisée"]);
    exit;
}

if ($action === "connexion") {

    $email      = trim($donnees["email"] ?? "");
    $motDePasse = $donnees["motDePasse"] ?? "";

    if ($email === "" || $motDePasse === "") {
        echo json_encode([
            "success" => false,
            "message" => "Email et mot de passe obligatoires"
        ]);
        exit;
    }

    echo json_encode($login->seConnecter($email, $motDePasse));

} elseif ($action === "inscription") {

    $IdCommune  = trim($donnees["IdCommune"] ?? "");
    $Nom        = trim($donnees["Nom"] ?? "");
    $Prenom     = trim($donnees["Prenom"] ?? "");
    $email      = trim($donnees["email"] ?? "");
    $motDePasse = $donnees["motDePasse"] ?? "";
    $statut     = trim($donnees["statut"] ?? "");
    $telephone  = trim($donnees["telephone"] ?? "");

    if ($IdCommune === "" || $Nom === "" || $Prenom === "" ||
        $email === "" || $motDePasse === "" || $statut === "" || $telephone === "") {

        echo json_encode([
            "success" => false,
            "message" => "Tous les champs sont obligatoires"
        ]);
        exit;
    }

    echo json_encode($login->inscription(
        $IdCommune, $Nom, $Prenom, $email, $motDePasse, $statut, $telephone
    ));

} else {
    // Action inconnue : on renvoie toujours du JSON valide,
    // sinon reponse.json() plante côté Vue
    echo json_encode([
        "success" => false,
        "message" => "Action inconnue"
    ]);
}
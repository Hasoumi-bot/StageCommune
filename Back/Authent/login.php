<?php

include("configuration.php");


class login{
    private $DB;

    private function  __construct($conn){
        $this->DB = $conn
    }

    public function connecter($connexion, $email, $motDePasse)
    {
        try{

        $requete = $connexion->prepare(
            "SELECT * FROM utilisateur WHERE EMAILUTILISATEUR =: email"
        );

        $requete->execute([':email'=>$email]);
        $utilisateur = $requete->fetch(PDO::FETCH_ASSOC);

        if(!$utilisateur){
            return [
                "success" => false,
                "message" => "Email ou mot de passe incorrect"
            ]; 
        }
        elseif(!password_verify($motDePasse, $utilisateur['MDPUTILISATEUR'])){
            return [
                "success" => false;
                "message" => "Email ou mot de passe incorrect"
            ];
        }

        else{
            return [
                "success" => true ,
                "message" => "Connexion reussie",
                "utilisateur" => $utilisateur
            ];
        }
      }

    }catch(PDOException $e){

       return [
           "success" => false,
           "message" => "Erreur lors de la connexion"
      ];
    }

    public function inscription($connexion,$IdCommune, $Nom, $Prenom, $email, $statut, $telephone, $motDePasse){
        try{


            $requete = $connexion->prepare(
                "INSERT INTO utilisateur(IDENTIFIANTCOMMUNE,NOMUTILISATEUR,	PRENOMUTILISATEUR,	EMAILUTILISATEUR, MDPUTILISATEUR,STATUTUTILISATEUR,TELEPHONEUTILISATEUR) VALUES 
                (:IdCommune,:nom,:prenom,:mail,:motdepasse,:statut,:telephone)"
            );

            $requete->execute([
                ':IdCommune' => $IdCommune,
                ':nom' => $Nom,
                ':prenom' => $Prenom,
                ':mail' => $email,
                ':motdepasse' => 
            ])
        }

    }
}
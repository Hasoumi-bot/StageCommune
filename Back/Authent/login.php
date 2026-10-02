<?php

include("configuration.php");


class login{
    private $DB;

    public function  __construct($conn){
        $this->DB = $conn;
    }

    public function connecter($email, $motDePasse)
    {
        try{

        $requete = $this->DB->prepare(
            "SELECT * FROM utilisateur WHERE EMAILUTILISATEUR = :email"
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
                "success" => false,
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
  }

    public function inscription($IdCommune, $Nom, $Prenom, $email, $motDePasse, $statut, $telephone){
        try{


            $requete = $this->DB->prepare(
                "INSERT INTO utilisateur(IDENTIFIANTCOMMUNE,NOMUTILISATEUR,	PRENOMUTILISATEUR,	EMAILUTILISATEUR, MDPUTILISATEUR,STATUTUTILISATEUR,TELEPHONEUTILISATEUR) VALUES 
                (:IdCommune,:nom,:prenom,:mail,:motdepasse,:statut,:telephone)"
            );

            $requete->execute([
                ':IdCommune' => $IdCommune,
                ':nom' => $Nom,
                ':prenom' => $Prenom,
                ':mail' => $email,
                ':motdepasse' => password_hash($motDePasse, PASSWORD_DEFAULT),
                ':statut' => $statut,
                ':telephone' => $telephone
            ]);

            return[
            "success" => true,
            "message" => "inscrition reussie"
            ];
        }
        catch(PDOException $e){

        return[
            "success" => false,
            "message" => "Erreur lors de la connexion"
        ];
        }
      }
}
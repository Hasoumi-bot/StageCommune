<?php

class login
{
    private $DB;

    private const STATUTS_VALIDES = ['admin', 'controleur'];

    public function __construct($conn)
    {
        $this->DB = $conn;
    }

    public function seConnecter($email, $motDePasse)
    {
        try {
            $requete = $this->DB->prepare(
                "SELECT * FROM utilisateur WHERE EMAILUTILISATEUR = :email"
            );
            $requete->execute([':email' => $email]);
            $utilisateur = $requete->fetch(PDO::FETCH_ASSOC);


            if (!$utilisateur || !password_verify($motDePasse, $utilisateur['MDPUTILISATEUR'])) {
                return [
                    "success" => false,
                    "message" => "Email ou mot de passe incorrect"
                ];
            }

            // if (!$utilisateur) {
            //     return ["success" => false, "message" => "DEBUG : email introuvable"];
            // }

            // if (!password_verify($motDePasse, $utilisateur['MDPUTILISATEUR'])) {
            //     return [
            //         "success" => false,
            //         "message" => "DEBUG : hash de " . strlen($utilisateur['MDPUTILISATEUR'])
            //          . " caractères, début = " . substr($utilisateur['MDPUTILISATEUR'], 0, 4)
            // ];
            // }

            $actuel = new DateTime();

            $requete = $this->DB->prepare(
                "UPDATE utilisateur
                 SET DATEDERNIEREMODIFICATIONUTILISATEUR = :dateModification
                 WHERE NUMEROUTILISATEUR = :numeroUtilisateur"
            );
            $requete->execute([
                ':dateModification'  => $actuel->format('Y-m-d H:i:s'),
                ':numeroUtilisateur' => $utilisateur['NUMEROUTILISATEUR']
            ]);

            unset($utilisateur['MDPUTILISATEUR']);

            return [
                "success"     => true,
                "message"     => "Connexion réussie",
                "utilisateur" => $utilisateur
            ];

        } catch (PDOException $e) {
            return [
                "success" => false,
                "message" => "Erreur lors de la connexion"
            ];
        }
    }

    public function inscription($IdCommune, $Nom, $Prenom, $email, $motDePasse, $statut, $telephone)
    {

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ["success" => false, "message" => "Adresse email invalide"];
        }

        if (strlen($motDePasse) < 6) {
            return ["success" => false, "message" => "Le mot de passe doit contenir au moins 6 caractères"];
        }

        if (!in_array($statut, self::STATUTS_VALIDES, true)) {
            return ["success" => false, "message" => "Statut invalide"];
        }

        try {

            if ($statut === 'admin') {
                $verif = $this->DB->query(
                    "SELECT COUNT(*) FROM utilisateur WHERE STATUTUTILISATEUR = 'admin'"
                );
                if ((int) $verif->fetchColumn() > 0) {
                    return [
                        "success" => false,
                        "message" => "Un administrateur existe déjà. Choisissez le statut Contrôleur."
                    ];
                }
            }

            $requete = $this->DB->prepare(
                "SELECT IDENTIFIANTCOMMUNE FROM commune WHERE IDENTIFIANTCOMMUNE = :cp "
            );
            $requete->execute([':cp' => $IdCommune]);
            $IdCommune = $requete->fetchColumn();

            if($IdCommune === false){
                return ["succes" => false,
                        "message" => "Ce code postal n'existe pas dans la base de données"];
            }


            $dateActuel = new DateTime();

            $requete = $this->DB->prepare(
                "INSERT INTO utilisateur (
                    IDENTIFIANTCOMMUNE, NOMUTILISATEUR, PRENOMUTILISATEUR,
                    EMAILUTILISATEUR, MDPUTILISATEUR, STATUTUTILISATEUR,
                    TELEPHONEUTILISATEUR, DATECREATIONUTILISATEUR,
                    DATEDERNIEREMODIFICATIONUTILISATEUR
                ) VALUES (
                    :IdCommune, :nom, :prenom,
                    :mail, :motdepasse, :statut,
                    :telephone, :dateCreation, NULL
                )"
            );

            $requete->execute([
                ':IdCommune'    => $IdCommune,
                ':nom'          => $Nom,
                ':prenom'       => $Prenom,
                ':mail'         => $email,
                ':motdepasse'   => password_hash($motDePasse, PASSWORD_DEFAULT),
                ':statut'       => $statut,
                ':telephone'    => $telephone,
                ':dateCreation' => $dateActuel->format('Y-m-d H:i:s'),
            ]);

            return [
                "success" => true,
                "message" => "Inscription réussie"
            ];

        } catch (PDOException $e) {
            
            if ($e->getCode() == 23000) {
                return [
                    "success" => false,
                    "message" => "Cet email est déjà utilisé ou la commune n'existe pas"
                ];
            }

            return [
                "success" => false,
                "message" => "Erreur lors de l'inscription"
            ];
        }
    }

    public function deconnexion(){
        
    }
}
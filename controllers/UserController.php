<?php
// Vérification des fichiers nécessaires
if (!file_exists('../models/userModel.php')) {
    die("Erreur : Le fichier '../models/userModel.php' est introuvable.");
}

if (!file_exists('../database/database.php')) {
    die("Erreur : Le fichier '../database/database.php' est introuvable.");
}

// Inclusion des fichiers requis
require_once '../models/userModel.php';
require_once '../database/database.php';

class UserController {
    private $model;

    // Constructeur : initialise le modèle avec la base de données
    public function __construct() {
        $db = (new Database())->connect();
        $this->model = new UserModel($db);
    }

    // Méthode pour créer un utilisateur avec gestion de l'avatar
    public function createUser($data) {
        $avatarParDefaut = '/public/site/default-avatar.png'; // Avatar par défaut

        // Vérifier si un fichier a été uploadé
        if (!empty($_FILES['avatar']['name'])) {
            $dossierUpload = '../uploads/'; // Dossier où enregistrer l'avatar

            // Vérifier si le dossier existe, sinon le créer
            if (!is_dir($dossierUpload)) {
                mkdir($dossierUpload, 0777, true);
            }

            $nomFichier = time() . '_' . basename($_FILES['avatar']['name']); // Nom unique
            $cheminFinal = $dossierUpload . $nomFichier;

            // Déplacer le fichier uploadé
            if (move_uploaded_file($_FILES['avatar']['tmp_name'], $cheminFinal)) {
                $data['avatar'] = '/uploads/' . $nomFichier; // Chemin utilisable dans <img>
            } else {
                $data['avatar'] = $avatarParDefaut;
            }
        } else {
            $data['avatar'] = $avatarParDefaut;
        }

        // Enregistrer l'utilisateur avec l'avatar
        return $this->model->createUser($data);
    }

    // Méthode pour récupérer un utilisateur par ID
    public function getUserById($userId) {
        return $this->model->getUserById($userId);
    }

    // Méthode pour mettre à jour un utilisateur
    public function updateUser($data) {
        // Vérifier si l'utilisateur change son avatar
        if (!empty($_FILES['avatar']['name'])) {
            $dossierUpload = '../uploads/';

            if (!is_dir($dossierUpload)) {
                mkdir($dossierUpload, 0777, true);
            }

            $nomFichier = time() . '_' . basename($_FILES['avatar']['name']);
            $cheminFinal = $dossierUpload . $nomFichier;

            if (move_uploaded_file($_FILES['avatar']['tmp_name'], $cheminFinal)) {
                $data['avatar'] = '/uploads/' . $nomFichier;
            }
        }

        return $this->model->updateUser($data);
    }
    public function devenirVendeur($userId) {
        return $this->model->devenirVendeur($userId);
    }

}

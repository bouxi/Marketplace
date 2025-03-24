<?php
session_start();
require_once '../controllers/UserController.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$controller = new UserController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['user_id'];
    $data = [
        'id' => $userId,
        'firstName' => htmlspecialchars($_POST['firstName']),
        'lastName' => htmlspecialchars($_POST['lastName']),
        'birthdate' => $_POST['birthdate'],
        'phone' => htmlspecialchars($_POST['phone']),
        'email' => filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) ? $_POST['email'] : null,
        'username' => htmlspecialchars($_POST['username'])
    ];

    // Vérification de l'avatar
    if (!empty($_FILES['avatar']['name'])) {
        $dossierUpload = 'uploads/';
        $nomFichier = time() . '_' . basename($_FILES['avatar']['name']);
        $cheminFinal = $dossierUpload . $nomFichier;

        // Vérification du type de fichier
        $typesAutorises = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
        if (in_array($_FILES['avatar']['type'], $typesAutorises)) {
            if (move_uploaded_file($_FILES['avatar']['tmp_name'], $cheminFinal)) {
                $data['avatar'] = '/' . $cheminFinal; // Correction du chemin pour éviter les erreurs d'affichage
            }
        } else {
            echo "Format de fichier non autorisé.";
            exit;
        }
    }

    // Mise à jour de l'utilisateur
    if ($controller->updateUser($data)) {
        header("Location: profile.php"); // Redirection après mise à jour réussie
        exit;
    } else {
        echo "Erreur lors de la mise à jour du profil.";
    }
}


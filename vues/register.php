<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

// Inclure le fichier du contrôleur
require_once '../controllers/UserController.php';

// Fonction pour gérer l'upload de l'avatar
function uploadAvatar($avatar) {
    $target_dir = 'C:/MarketPlace/public/avatars/';
    $target_file = $target_dir . basename($avatar["name"]);
    $maxSize = 500000; // Taille maximale : 500 Ko
    $allowedFileTypes = ['jpg', 'png', 'jpeg', 'gif'];

    // Vérifications
    if ($avatar["size"] > $maxSize) {
        return "Le fichier est trop volumineux.";
    }
    $imageFileType = strtolower(pathinfo($avatar["name"], PATHINFO_EXTENSION));
    if (!in_array($imageFileType, $allowedFileTypes)) {
        return "Seuls les fichiers JPG, PNG, JPEG et GIF sont autorisés.";
    }
    if (!getimagesize($avatar["tmp_name"])) {
        return "Le fichier téléchargé n'est pas une image valide.";
    }
    if (!move_uploaded_file($avatar["tmp_name"], $target_file)) {
        return "Échec du téléchargement de l'avatar.";
    }
    return $target_file; // Retourner le chemin du fichier en cas de succès
}

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Récupérer les données du formulaire
    $firstName = htmlspecialchars($_POST['firstName']);
    $lastName = htmlspecialchars($_POST['lastName']);
    $birthdate = htmlspecialchars($_POST['birthdate']);
    $phone = htmlspecialchars($_POST['phone']);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $username = htmlspecialchars($_POST['username']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    $avatar = $_FILES['avatar'];

    // Validation des données
    if (!$email) {
        echo "L'adresse e-mail n'est pas valide.";
        exit();
    }
    if ($password !== $confirmPassword) {
        echo "Les mots de passe ne correspondent pas.";
        exit();
    }
    if (strlen($password) < 8) {
        echo "Le mot de passe doit contenir au moins 8 caractères.";
        exit();
    }

    // Hachage du mot de passe
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Gestion de l'avatar
    $avatarPath = uploadAvatar($avatar);
    if (!is_string($avatarPath)) {
        echo $avatarPath; // Afficher l'erreur liée à l'upload
        exit();
    }

    // Préparer les données pour l'insertion
    $data = [
        'firstName' => $firstName,
        'lastName' => $lastName,
        'birthdate' => $birthdate,
        'phone' => $phone,
        'email' => $email,
        'avatar' => $avatarPath,
        'username' => $username,
        'password' => $hashedPassword,
    ];
    // Instancier le contrôleur
    $controller = new UserController();

    // Créer l'utilisateur
    if ($controller->createUser($data)) {
        echo "Utilisateur créé avec succès. Redirection...";
        header("Location: Article.php");
    } else {
        echo "Erreur lors de la création de l'utilisateur.";
    }
    exit();
}


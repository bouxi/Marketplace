<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
// Inclure le contrôleur et le modèle
require_once '/MarketPlace/controllers/usercontroller.php';
require_once '/MarketPlace/models/users.sql';

// Connexion à la base de données
$db = new mysqli('51.91.12.160:9107', 'honore_christian', 'l2yQcYGfGefgHFrT', 'honore_christian');

if ($db->connect_error) {
    die("La connexion à la base de données a échoué: " . $db->connect_error);
}

// Instancier le modèle
$model = new Users($db);

// Instancier le contrôleur
$controller = new UserController($model);

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $birthdate = $_POST['birthdate'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $avatar = $_FILES['avatar'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    // Gérer l'upload de l'image d'avatar
    $target_dir = "/MarketPlace/public/avatars/";
    $target_file = $target_dir . basename($avatar["name"]);
    $uploadOk = 1;

    // Vérifier la taille maximale de l'avatar (en octets)
    $maxSize = 500000; // Taille maximale en octets
    if ($avatar["size"] > $maxSize) {
        echo "Désolé, votre fichier est trop volumineux.";
        $uploadOk = 0;
    }
// a corriger 
 // Autoriser certains types de fichiers
$imageFileType = strtolower(pathinfo($avatar["name"], PATHINFO_EXTENSION));
if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
    echo "Le format de fichier n'est pas autorisé. Merci d'utiliser un fichier JPG, PNG, JPEG ou GIF.";
    $uploadOk = 0;
}


    // Vérifier si les mots de passe saisis sont identiques
    if ($password !== $confirmPassword) {
        echo "Les mots de passe saisis ne sont pas identiques. Veuillez réessayer.";
        $uploadOk = 0;
    }

    // Vérifier si le fichier n'est pas vide
    if ($avatar["error"] !== UPLOAD_ERR_OK) {
        echo "Impossible de télécharger l'avatar. Réessayez s'il vous plaît.";
        $uploadOk = 0;
    }

    // Vérifier si le fichier existe déjà
    if (file_exists($target_file)) {
        echo "Désolé, le fichier existe déjà.";
        $uploadOk = 0;
    }

    // Vérifier si le fichier est une image réelle
    $check = getimagesize($avatar["tmp_name"]);
    if ($check === false) {
        echo "Le fichier n'est pas une image.";
        $uploadOk = 0;
    }

    // Si tout est correct, préparer et exécuter la requête SQL d'insertion via le contrôleur
    if ($uploadOk) {
        if (move_uploaded_file($avatar["tmp_name"], $target_file)) {
            $data = [
                'firstName' => $firstName,
                'lastName' => $lastName,
                'birthdate' => $birthdate,
                'phone' => $phone,
                'email' => $email,
                'avatar' => $target_file,
                'username' => $username,
                'password' => $password,
            ];
            if ($controller->createUser($data)) {
                header("Location: article.html"); // Redirection vers la page article.html
                exit();
            } else {
                echo "Erreur lors de la création de l'utilisateur: " . $db->error;
            }
        } else {
            echo "Erreur lors du téléchargement de l'avatar.";
        }
    }
}


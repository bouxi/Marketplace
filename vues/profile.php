<?php
session_start();
require_once '../controllers/UserController.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Récupérer les infos de l'utilisateur
$controller = new UserController();
$user = $controller->getUserById($_SESSION['user_id']);

if (!$user) {
    echo "Erreur : utilisateur introuvable.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon Profil</title>
    <link rel="stylesheet" href="../public/css/style.css"> <!-- Ajoute un CSS si nécessaire -->
</head>
<body>

<h2>Mon Profil</h2>

<div class="profile-container">
    <img src="<?= $user['avatar'] ?>" alt="Avatar" class="profile-avatar" width="150">

    <p><strong>Prénom :</strong> <?= htmlspecialchars($user['firstName']) ?></p>
    <p><strong>Nom :</strong> <?= htmlspecialchars($user['lastName']) ?></p>
    <p><strong>Date de naissance :</strong> <?= htmlspecialchars($user['birthdate']) ?></p>
    <p><strong>Téléphone :</strong> <?= htmlspecialchars($user['phone']) ?></p>
    <p><strong>Email :</strong> <?= htmlspecialchars($user['email']) ?></p>
    <p><strong>Nom d'utilisateur :</strong> <?= htmlspecialchars($user['username']) ?></p>

    <a href="Edit-Profile.php" class="btn btn-primary">Modifier mon profil</a>
</div>

</body>
</html>

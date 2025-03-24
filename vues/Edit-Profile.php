<?php
session_start();
require_once '../controllers/UserController.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$controller = new UserController();
$user = $controller->getUserById($_SESSION['user_id']); // Récupère les infos de l'utilisateur

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier mon profil</title>
</head>
<body>

<h2>Modifier mon profil</h2>

<form action="update-profile.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="user_id" value="<?= $user['id'] ?>">

    <label>
        <input type="text" name="firstName" value="<?= $user['firstName'] ?>" required>
    </label><br>
    <label>
        <input type="text" name="lastName" value="<?= $user['lastName'] ?>" required>
    </label><br>
    <label>
        <input type="date" name="birthdate" value="<?= $user['birthdate'] ?>" required>
    </label><br>
    <label>
        <input type="text" name="phone" value="<?= $user['phone'] ?>" required>
    </label><br>
    <label>
        <input type="email" name="email" value="<?= $user['email'] ?>" required>
    </label><br>

    <label>Avatar actuel :</label><br>
    <img src="<?= $user['avatar'] ?>" alt="Avatar" id="avatar-preview" width="100"><br>
    <input type="file" name="avatar" id="avatar-input"><br>

    <label>
        <input type="text" name="username" value="<?= $user['username'] ?>" required>
    </label><br>

    <button type="submit">Sauvegarder</button>
</form>

<script>
    document.getElementById('avatar-input').addEventListener('change', function(event) {
        let reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('avatar-preview').src = e.target.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    });
</script>

</body>
</html>

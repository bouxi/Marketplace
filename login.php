<?php
session_start();
require_once 'src/lib/dbConnect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $db->prepare("SELECT id, lastName, firstName, username, email, phone, birthdate, password, role, avatar FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);


    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['lastName'] = $user['lastName'];
        $_SESSION['firstName'] = $user['firstName'];
        $_SESSION['phone'] = $user['phone'];
        $_SESSION['birthdate'] = $user['birthdate'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['avatar'] = $user['avatar'];
        // Création de la variable de session indiquant que l'utilisateur est connecté
        $_SESSION['user'] = [
                'username' => $username,
                'id' => $user['id'],
        ];

        header('Location: dashboard.php');
        exit();
    } else {
        $error = "Nom d'utilisateur ou mot de passe incorrect.";
    }
}

$title = "Connexion";
require_once 'src/lib/dbClose.php';
require 'template/header.php';
?>

<div class="container p-5">
    <h1 class="display-4 fw-medium text-body-emphasis">Connexion</h1>
    <?php if (isset($error)) : ?>
        <div class="alert alert-danger"> <?= $error ?> </div>
    <?php endif; ?>
    <form action="login.php" method="post">
      
        <label for="username" class="form-label">Nom d'utilisateur</label>
        <input type="text" class="form-control mb-3" id="username" name="username" placeholder="Nom d'utilisateur" autocomplete="off" required>
        
        <label for="password" class="form-label">Mot de passe</label>
        <input type="password" class="form-control mb-3" id="password" name="password" autocomplete="off" required>

        <a href="register.php" class="link-secondary">Pas encore de compte ? Inscrivez-vous ici.</a>
        
        <button class="w-100 mb-2 btn btn-lg rounded-3 mt-4" type="submit" id="button">Se connecter</button>
    </form>
    <p class="mt-3">Pas encore inscrit ? <a href="register.php" style="text-decoration: none">Inscrivez-vous ici</a></p>

</div>







<?php require 'template/footer.php'; ?>
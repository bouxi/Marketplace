<?php
session_start();
require_once 'src/lib/dbConnect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $db->prepare("SELECT id, nom, prenom, email, password, role, avatar FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['nom'] = $user['nom'];
        $_SESSION['prenom'] = $user['prenom'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['avatar'] = $user['avatar'];

        header('Location: dashboard.php');
        exit();
    } else {
        $error = "Email ou mot de passe incorrect.";
    }
}

$title = "Connexion";
require_once 'src/lib/dbClose.php';
require 'template/header.php';
?>

    <h2 class="text-center">Connexion</h2>
    <?php if (isset($error)) : ?>
        <div class="alert alert-danger"> <?= $error ?> </div>
    <?php endif; ?>
    <form action="login.php" method="post">
        <div class="mb-3">
            <label for="email" class="form-label">Adresse e-mail :</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Mot de passe :</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button class="btn btn-primary" type="submit">Se connecter</button>
    </form>
    <p class="mt-3">Pas encore inscrit ? <a href="inscription.php">Inscrivez-vous ici</a></p>









<?php require 'template/footer.php'; ?>
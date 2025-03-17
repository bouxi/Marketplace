<?php
global $isLoggedIn;
$title = "MarketPlace";
require 'template/header.php';
?>

<div class="container p-5">
    <h1>Market Place</h1>


    <h2>Bienvenue</h2>

    <div class="d-flex justify-content-center">
        <?php if ($isLoggedIn): ?>
            <a href="logout.php" class="btn btn-primary mx-2">Déconnexion</a>
        <?php else: ?>
            <a href="login.php" class="btn btn-primary mx-2">Connexion</a>
        <?php endif; ?>

        <?php if ($isLoggedIn): ?>
            <a href="dashboard.php" class="btn btn-primary mx-2">Profil</a>
        <?php else: ?>
            <a href="register.php" class="btn btn-primary mx-2">Inscription</a>
        <?php endif; ?>

    </div>
</div>
<?php require 'template/footer.php'; ?>
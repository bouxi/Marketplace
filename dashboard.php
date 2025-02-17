<?php
session_start();
require_once 'src/lib/dbConnect.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_nom = $_SESSION['nom'];
$user_prenom = $_SESSION['prenom'];
$user_email = $_SESSION['email'];
$user_role = $_SESSION['role'];
$user_avatar = $_SESSION['avatar'];

$title = "Dashboard";
require_once 'src/lib/dbClose.php';
require 'template/header.php';
?>


<div class="container mt-5">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <img src="uploads/avatars/<?php echo $user_avatar; ?>" class="card-img-top" alt="Avatar">
                <div class="card-body text-center">
                    <h5 class="card-title"> <?php echo $user_prenom . ' ' . $user_nom; ?> </h5>
                    <p class="card-text"> <?php echo ucfirst($user_role); ?> </p>
                    <p class="card-text"><small class="text-muted"> <?php echo $user_email; ?> </small></p>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <h3>Bienvenue, <?php echo $user_prenom; ?>!</h3>
            <p>Vous êtes connecté en tant que <strong><?php echo ucfirst($user_role); ?></strong>.</p>
            <a href="logout.php" class="btn btn-primary">Déconnexion</a>
        </div>
    </div>
</div>

<?php require 'template/footer.php'; ?>
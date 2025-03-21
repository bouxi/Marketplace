<?php
session_start();
require_once 'src/lib/dbConnect.php'; // Fichier de connexion BDD

$title = "Inscription";
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $lastName = trim($_POST['lastName']);
    $firstName = trim($_POST['firstName']);
    $username = trim($_POST['username']);
    $phone = trim($_POST['phone']);
    $birthdate = trim($_POST['birthdate']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = isset($_POST['role']) && in_array($_POST['role'], ['acheteur', 'vendeur']) ? $_POST['role'] : 'acheteur';

    // Validation des champs
    if (empty($lastName)) {
        $errors['lastName'] = "Le Nom de l'utilisateur est requis.";
    }
    if (empty($firstName)) {
        $errors['firstName'] = "Le Prénom de l'utilisateur est requis.";
    }
    if (empty($username)) {
        $errors['username'] = "Le Nom d'utilisateur est requis.";
    }
    if (empty($phone)) {
        $errors['phone'] = "Le numéro de téléphone est requis.";
    }
    if (empty($birthdate)) {
        $errors['birthdate'] = "La date de naissance est requise.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "L'adresse email est invalide.";
    }
    if (strlen($password) < 6) {
        $errors['password'] = "Le mot de passe doit contenir au moins 6 caractères.";
    }
    if ($password !== $confirm_password) {
        $errors['confirm_password'] = "Les mots de passe ne correspondent pas.";
    }

    // Gestion de l'avatar
    $avatar = 'default.png'; // Avatar par défaut
    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === 0) {
        $targetDir = 'uploads/avatars/';
        $avatarName = time() . "_" . basename($_FILES['avatar']['name']);
        $targetFilePath = $targetDir . $avatarName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

        $allowTypes = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array($fileType, $allowTypes)) {
            if (move_uploaded_file($_FILES['avatar']['tmp_name'], $targetFilePath)) {
                $avatar = $avatarName;
            }
        }
    }

    // Vérifier si l'email existe déjà
    if (empty($errors)) {
        $stmt = $db->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $errors['email'] = "Cet email est déjà utilisé.";
        }
    }

    // Insertion dans la base de données si tout est bon
    if (empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $db->prepare("INSERT INTO users (lastName, firstName, username, email, phone, birthdate, password, role, avatar) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        if ($stmt->execute([$lastName, $firstName, $username, $email, $phone, $birthdate, $hashed_password, $role, $avatar])) {
            $_SESSION['success'] = "Inscription réussie. Vous pouvez vous connecter.";
            header('Location: login.php');
            exit;
        } else {
            $errors['general'] = "Une erreur est survenue lors de l'inscription. Veuillez réessayer.";
        }
    }
}

require_once ('src/lib/dbClose.php');
require_once 'template/header.php';
?>

<div id="container" class="container">
    <div class="row justify-content-center">
        <div class="card-body">
            <?php if (!empty($errors)) : ?>
                <div class="alert alert-danger">
                    <?php foreach ($errors as $error) : ?>
                        <p><?= htmlspecialchars($error) ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
                    <h1 class="display-4 fw-medium text-body-emphasis">Nouveau compte</h1>

                    <form action="register.php" enctype="multipart/form-data" id="form-register" method="POST">
                        <div class="row g-3">
                            <div class="col">
                                <label for="lastName" class="form-label">Votre nom :</label>
                                <input type="text" class="form-control mb-3" id="lastName" name="lastName" placeholder="Nom" autocomplete="off" value="<?= isset($_POST['lastName']) ? htmlspecialchars($_POST['lastName']) : '' ?>" required>
                            </div>
                            <div class="col">
                                <label for="firstName" class="form-label">Votre prénom :</label>
                                <input type="text" class="form-control mb-3" id="firstName" name="firstName" placeholder="Prénom" autocomplete="off" value="<?= isset($_POST['firstName']) ? htmlspecialchars($_POST['firstName']) : '' ?>" required>
                            </div>
                        </div>

                        <label for="birthdate" class="form-label">Date de naissance</label>
                        <input type="date" class="form-control" id="birthdate" name="birthdate" value="<?= isset($_POST['birthdate']) ? htmlspecialchars($_POST['birthdate']) : '' ?>" required>


                            <label for="username" class="form-label">Votre pseudo :</label>
                            <input type="text" class="form-control" id="username" name="username" value="<?= isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '' ?>" required>


                            <label for="email" class="form-label">Votre Email :</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>" required>


                            <label for="phone" class="form-label">Votre numéro de téléphone :</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="<?= isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : '' ?>" required>




                        <div class="mb-3">
                            <label for="password" class="form-label">Mot de passe :</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Confirmer le mot de passe :</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Avatar</label>
                            <input type="file" class="form-control" name="avatar">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Rôle :</label>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="role" value="acheteur" checked>
                                <label class="form-check-label">Acheteur</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="role" value="vendeur">
                                <label class="form-check-label">Vendeur</label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">S'inscrire</button>
                    </form>

    </div>
</div>


<?php require_once 'template/footer.php'; ?>

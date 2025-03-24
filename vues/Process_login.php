<?php
session_start(); // Démarrer la session

// Inclure les fichiers nécessaires
require_once '../database/database.php';

try {
    // Connexion à la base de données via la classe Database
    $db = (new Database())->connect();

    // Vérifier si le formulaire a été soumis
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Vérifier que les champs ne sont pas vides
        if (empty($_POST['username']) || empty($_POST['password'])) {
            die("Veuillez remplir tous les champs.");
        }

        // Récupérer les données du formulaire et éviter les failles XSS
        $username = htmlspecialchars($_POST['username']);
        $password = $_POST['password'];

        // Requête préparée pour éviter l'injection SQL
        $stmt = $db->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Vérifier si l'utilisateur existe et si le mot de passe est correct
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['username'] = $user['username'];
            $_SESSION['user_id'] = $user['id'];

            // Rediriger vers la page article.html après connexion réussie
            header("Location: Article.php");
            exit();
        } else {
            echo "Nom d'utilisateur ou mot de passe incorrect.";
        }
    }
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}


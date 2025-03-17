<?php
// Connexion à la base de données


$conn = new mysqli('51.91.12.160:9109', 'malacort_antoine', 'lWqUip20QangrHzH', 'honore');

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connexion échouée: " . $conn->connect_error);
}

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Rechercher l'utilisateur dans la base de données
    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Vérifier le mot de passe
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // Démarrer une session et enregistrer les informations de l'utilisateur
            session_start();
            $_SESSION['username'] = $username;
            $_SESSION['user_id'] = $row['id'];
            // Rediriger vers la page article.html après une connexion réussie
            header("Location: article.html");
            exit();
        } else {
            echo "Mot de passe incorrect.";
        }
    } else {
        echo "Utilisateur non trouvé.";
    }
}

$conn->close();
?>

<?php
try {
    $pdo = new PDO("mysql:host=51.91.12.160;dbname=marketplace", "honore_christian", "l2yQcYGfGefgHFrT");
    echo "Connexion réussie !";
} catch (PDOException $e) {
    die("Erreur PDO : " . $e->getMessage());
}

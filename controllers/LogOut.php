<?php
session_start();
session_destroy(); // Supprime toutes les variables de session

// Redirection vers la page de connexion ou la page d'accueil
header("Location: index.php");
exit;


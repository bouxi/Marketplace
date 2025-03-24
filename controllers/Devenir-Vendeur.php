<?php
session_start();
require_once 'UserController.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit;
}

$controller = new UserController();
$controller->devenirVendeur($_SESSION['user_id']);

// Rediriger vers la page de vente
header("Location: ../vues/vente.php");
exit;

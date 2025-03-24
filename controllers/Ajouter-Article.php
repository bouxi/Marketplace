<?php
session_start();
require_once 'ArticleController.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new ArticleController();
    $data = [
        'user_id' => $_SESSION['user_id'],
        'nom' => $_POST['nom'],
        'categorie' => $_POST['categorie'],
        'quantite' => $_POST['quantite'],
        'description' => $_POST['description'],
        'prix' => $_POST['prix']
    ];

    $controller->ajouterArticle($data);
    header("Location: ../vues/article.php");
    exit;
}

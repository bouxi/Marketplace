<?php
require_once 'template/fonctions.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Vérifie si l'utilisateur est connecté
$isLoggedIn = isset($_SESSION['user']);

// Vérifie si l'utilisateur est vendeur
$isSeller = $isLoggedIn && isset($_SESSION['role']) && $_SESSION['role'] === 'vendeur';

?><!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php if(isset($title)): ?>
        <?= $title; ?>
        <?php else : ?>
            Mon site
        <?php endif ?>
    </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<nav class="navbar navbar-expand-md">
    <div class="container-fluid">
        <a class="navbar-brand offset-lg-2" href="#"><img src="/Assets/Logo.svg" alt="logo"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Basculer la navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse offset-lg-4 offset-md-1 id="navbarCollapse">
        <form class="d-flex" role="search">
            <input class="form-control me-2" type="search" placeholder="Rechercher des articles" aria-label="Recherche">
            <button class="btn btn-outline-success" type="submit">
                <img src="/Assets/search.svg">
            </button>
        </form>
        <ul class="navbar-nav me-auto mb-2 mb-md-0 ms-4">
            <li class="nav-item ms-2">
                <a class="navbar-brand" href="#"><img src="/Assets/message.svg"></a>
            </li>
            <li class="nav-item">
                <a class="navbar-brand" href="#"><img src="/Assets/pannier.svg"></a>
            </li>

            <li class="nav-item me-3">
                <?php if($isSeller): ?>
                    <button onclick="location.href='vendre.php'" type="button" class="btn btn-success">Vends tes articles</button>
                <?php else: ?>
                    <button onclick="location.href='acheter.php'"  type="button" class="btn btn-success">Article en vente</button>
                <?php endif; ?>
            </li>
            <li class="nav-item">
                <div class="flex-shrink-0 dropdown">
                    <a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="https://github.com/mdo.png" alt="mdr" width="32" height="32" class="rounded-circle">
                    </a>
                    <ul class="dropdown-menu text-small shadow">
                        <li><a class="dropdown-item" href="#"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Profil</font></font></a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">se déconnecter</font></font></a></li>
                    </ul>
                </div>
            </li>
        </ul>

    </div>
    </div>
</nav>





<header>
    <nav class="navbar navbar-expand-md">
        <div class="container-fluid">
            <a class="navbar-brand offset-lg-2" href="#"><img src="/public/site/Logo.svg" alt="logo"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Basculer la navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse offset-lg-4 offset-md-1" id="navbarCollapse">
                <form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Rechercher des articles" aria-label="Recherche">
                    <button class="btn btn-outline-success" type="submit">
                        <img src="/public/site/search.svg" alt="">
                    </button>
                </form>
                <ul class="navbar-nav me-auto mb-2 mb-md-0 ms-4">
                    <li class="nav-item ms-2">
                        <a class="navbar-brand" href="#"><img src="/public/site/message.svg" alt=""></a>
                    </li>
                    <li class="nav-item">
                        <a class="navbar-brand" href="#"><img src="/public/site/pannier.svg" alt=""></a>
                    </li>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li class="nav-item">
                            <a href="/controllers/devenir-vendeur.php" class="btn btn-success">Vendre un article</a>
                        </li>
                    <?php endif; ?>

                    <?php
                    $current_page = basename($_SERVER['PHP_SELF']); // Récupère le nom du fichier actuel
                    ?>

                    <li class="nav-item">
                        <div class="flex-shrink-0 dropdown"
                            <?= ($current_page == 'index.php') ? 'style="display: none;"' : ''; ?>>
                            <a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="https://github.com/mdo.png" alt="mdr" width="32" height="32" class="rounded-circle">
                            </a>
                            <ul class="dropdown-menu text-small shadow">
                                <li><a class="dropdown-item" href="/vues/profile.php">Mon Profil</a></li>
                                <li><a class="dropdown-item" href="/vues/edit-profile.php">Modifier mon Profil</a></li>
                                <li><a class="dropdown-item" href="/controllers/logOut.php">Déconnexion</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>

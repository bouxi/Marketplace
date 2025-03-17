<?php
function nav_item(string $lien, string $titre, string $linkClass = ''): string
{
    $classe = 'nav-link';
    if ($_SERVER['SCRIPT_NAME'] === $lien) {
        $classe .= ' active';
    }
    return <<<HTML
        <li class="$linkClass">
            <a class="$classe" href="$lien">$titre</a>
        </li>
HTML;
}

function nav_menu (string $linkClass = ''): string
{
    return
        nav_item('/index.php', 'Accueil', $linkClass) .
        nav_item('/login.php', 'Connexion', $linkClass) .
        nav_item('/logout.php', 'Déconnexion', $linkClass) .
        nav_item('/dashboard.php', 'Dashboard', $linkClass) .
        nav_item('/register.php', 'Inscription', $linkClass) .
        nav_item('/test.php', 'TEST', $linkClass) .
        nav_item('/contact.php', 'Contact', $linkClass);
}
?>
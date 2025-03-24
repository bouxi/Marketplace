<?php
require_once '../controllers/ArticleController.php';

$controller = new ArticleController();
$articles = $controller->getAllArticles(); // Récupère tous les articles
?>

<body>
<?php (include 'navbar.php') ?>

<h2>Articles en vente</h2>

<?php foreach ($articles as $article): ?>
    <div class="article">
        <h3><?= htmlspecialchars($article['nom']) ?></h3>
        <p>Catégorie : <?= htmlspecialchars($article['categorie']) ?></p>
        <p>Prix : <?= htmlspecialchars($article['prix']) ?>€</p>
        <p>Description : <?= htmlspecialchars($article['description']) ?></p>

        <!-- Affichage des images -->
        <?php if (!empty($article['photo1'])): ?>
            <img src="<?= $article['photo1'] ?>" width="150" alt="">
        <?php endif; ?>

        <?php if (!empty($article['photo2'])): ?>
            <img src="<?= $article['photo2'] ?>" width="150" alt="">
        <?php endif; ?>

        <?php if (!empty($article['photo3'])): ?>
            <img src="<?= $article['photo3'] ?>" width="150" alt="">
        <?php endif; ?>

    </div>
<?php endforeach; ?>

</body>


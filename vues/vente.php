<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Vendre un article</title>
</head>
<body>

<h2>Ajouter un nouvel article</h2>

<form action="../controllers/ajouter-article.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?>">

    <input type="text" name="nom" placeholder="Nom de l'article" required><br>
    <input type="text" name="categorie" placeholder="Catégorie" required><br>
    <input type="number" name="quantite" placeholder="Quantité" required><br>
    <textarea name="description" placeholder="Description" required></textarea><br>
    <input type="number" step="0.01" name="prix" placeholder="Prix" required><br>

    <label>Photos de l'article (max 3) :</label><br>
    <input type="file" name="photo1" accept="image/*"><br>
    <input type="file" name="photo2" accept="image/*"><br>
    <input type="file" name="photo3" accept="image/*"><br>

    <button type="submit">Mettre en vente</button>
</form>


</body>
</html>

<?php
session_start();
require_once '../models/ArticleModel.php';
require_once '../database/database.php';

class ArticleController {
    private $model;

    public function __construct() {
        $db = (new Database())->connect();
        $this->model = new ArticleModel($db);
    }

    public function ajouterArticle($data) {
        return $this->model->ajouterArticle($data);
    }

    public function getAllArticles() {
        return $this->model->getAllArticles();
    }
}

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit;
}

// Dossier où on enregistre les images
$dossierUpload = '../uploads/articles/';

// Vérifier si le dossier existe, sinon le créer
if (!file_exists($dossierUpload)) {
    mkdir($dossierUpload, 0777, true);
}

// Fonction pour enregistrer une image
function uploadImage($file, $dossierUpload) {
    if (!empty($file['name'])) {
        $nomFichier = time() . '_' . basename($file['name']);
        $cheminFinal = $dossierUpload . $nomFichier;

        if (move_uploaded_file($file['tmp_name'], $cheminFinal)) {
            return str_replace('../', '', $cheminFinal); // Retourne le chemin relatif
        }
    }
    return NULL;
}

// Vérifier si la requête est un POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new ArticleController();
    $data = [
        'user_id' => $_SESSION['user_id'],
        'nom' => $_POST['nom'],
        'categorie' => $_POST['categorie'],
        'quantite' => $_POST['quantite'],
        'description' => $_POST['description'],
        'prix' => $_POST['prix'],
        'photo1' => uploadImage($_FILES['photo1'], $dossierUpload),
        'photo2' => uploadImage($_FILES['photo2'], $dossierUpload),
        'photo3' => uploadImage($_FILES['photo3'], $dossierUpload)
    ];

    // Ajouter l’article avec les images
    $controller->ajouterArticle($data);
    header("Location: ../vues/article.php");
    exit;
}

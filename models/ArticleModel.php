<?php
class ArticleModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function ajouterArticle($data) {
        $stmt = $this->db->prepare("INSERT INTO articles (user_id, nom, categorie, quantite, description, prix, photo1, photo2, photo3) 
                                VALUES (:user_id, :nom, :categorie, :quantite, :description, :prix, :photo1, :photo2, :photo3)");

        $stmt->bindParam(':user_id', $data['user_id']);
        $stmt->bindParam(':nom', $data['nom']);
        $stmt->bindParam(':categorie', $data['categorie']);
        $stmt->bindParam(':quantite', $data['quantite']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':prix', $data['prix']);
        $stmt->bindParam(':photo1', $data['photo1']);
        $stmt->bindParam(':photo2', $data['photo2']);
        $stmt->bindParam(':photo3', $data['photo3']);

        return $stmt->execute();
    }
    public function getAllArticles() {
        $stmt = $this->db->prepare("SELECT * FROM articles");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}


<?php
class UserModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    /**
     * Insère un nouvel utilisateur dans la base de données.
     * @param array $data Données de l'utilisateur à insérer.
     * @return bool True si l'insertion réussit, False sinon.
     */
    public function createUser($data) {
        try {
            // Préparer la requête d'insertion SQL avec PDO
            $stmt = $this->db->prepare("INSERT INTO users (firstName, lastName, birthdate, phone, email, avatar, username, password) 
                                        VALUES (:firstName, :lastName, :birthdate, :phone, :email, :avatar, :username, :password)");

            // Associer les paramètres
            $stmt->bindParam(':firstName', $data['firstName']);
            $stmt->bindParam(':lastName', $data['lastName']);
            $stmt->bindParam(':birthdate', $data['birthdate']);
            $stmt->bindParam(':phone', $data['phone']);
            $stmt->bindParam(':email', $data['email']);
            $stmt->bindParam(':avatar', $data['avatar']);
            $stmt->bindParam(':username', $data['username']);
            $stmt->bindParam(':password', $data['password']); // Assurez-vous que le mot de passe est hashé avant insertion

            // Exécuter la requête
            return $stmt->execute();

        } catch (PDOException $e) {
            error_log($e->getMessage()); // Enregistrer l'erreur
            return false;
        }
    }

    /**
     * Récupère un utilisateur par son ID.
     * @param int $userId ID de l'utilisateur.
     * @return array|false Données de l'utilisateur ou False si introuvable.
     */
    public function getUserById($userId) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id");
            $stmt->bindValue(':id', $userId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    /**
     * Met à jour les informations d'un utilisateur.
     * @param array $data Données de l'utilisateur à mettre à jour.
     * @return bool True si la mise à jour réussit, False sinon.
     */
    public function updateUser($data) {
        try {
            // Construction dynamique de la requête pour éviter de mettre à jour l'avatar si non modifié
            $sql = "UPDATE users SET firstName = :firstName, lastName = :lastName, birthdate = :birthdate, 
                    phone = :phone, email = :email, username = :username";

            if (!empty($data['avatar'])) {
                $sql .= ", avatar = :avatar";
            }

            $sql .= " WHERE id = :id";

            $stmt = $this->db->prepare($sql);

            // Lier les valeurs
            $stmt->bindParam(':firstName', $data['firstName']);
            $stmt->bindParam(':lastName', $data['lastName']);
            $stmt->bindParam(':birthdate', $data['birthdate']);
            $stmt->bindParam(':phone', $data['phone']);
            $stmt->bindParam(':email', $data['email']);
            $stmt->bindParam(':username', $data['username']);
            $stmt->bindParam(':id', $data['id'], PDO::PARAM_INT);

            if (!empty($data['avatar'])) {
                $stmt->bindParam(':avatar', $data['avatar']);
            }

            return $stmt->execute();

        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }
    public function devenirVendeur($userId) {
        $stmt = $this->db->prepare("UPDATE users SET role = 'vendeur' WHERE id = :id");
        $stmt->bindParam(':id', $userId);
        return $stmt->execute();
    }

}

<?php

class UserController {
    private $model;

    public function __construct($model) {
        $this->model = $model;
    }

    public function createUser($data) {
        return $this->model->insertUser($data);
    }
}

class UserModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function insertUser($data) {
        $stmt = $this->db->prepare("INSERT INTO users (firstName, lastName, birthdate, phone, email, avatar, username, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
        $stmt->bind_param("ssssssss", $data['firstName'], $data['lastName'], $data['birthdate'], $data['phone'], $data['email'], $data['avatar'], $data['username'], $hashedPassword);
        return $stmt->execute();
    }
}
?>

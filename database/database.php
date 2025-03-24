<?php
class Database {
    private $host = '51.91.12.160';
    private $user = 'honore_christian';
    private $password = 'l2yQcYGfGefgHFrT';
    private $dbname = 'marketplace';

    private $port = 9107;

    public function connect() {
        try {
            $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->dbname . ";port=" . $this->port . ";charset=utf8";
            return new PDO($dsn, $this->user, $this->password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
        } catch (PDOException $e) {
            die("Erreur de connexion à la base de données ha ha ha ha recommene lol : " . $e->getMessage());
        }
    }
}
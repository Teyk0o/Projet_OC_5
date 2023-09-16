<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

class Articles {
    private $db;

    public function __construct() {
        try {
            $this->db = new PDO('mysql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $dbName = $_ENV['DB_NAME'], $dbUser = $_ENV['DB_USER'], $dbPass = $_ENV['DB_PASS']);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('Erreur de connexion: ' . $e->getMessage());
        }
    }

    public function getLastArticle() {
        $query = 'SELECT * FROM posts ORDER BY last_modified DESC LIMIT 1';
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllArticles() {
        $query = 'SELECT * FROM posts ORDER BY last_modified DESC';
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRecentArticles($limit) {
        $query = "SELECT * FROM posts ORDER BY last_modified DESC LIMIT :limit";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getRandomArticle() {
        $query = 'SELECT * FROM posts ORDER BY RAND() LIMIT 1';
        $result = $this->db->query($query);
        return $result->fetch();
    }
    
}
?>

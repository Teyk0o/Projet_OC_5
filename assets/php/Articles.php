<?php

require_once __DIR__.'/../../vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__.'/../../');
$dotenv->load();

class Articles
{

    /**
     * Variable de connexion à la base de données.
     *
     * @var PDO $database
     */
    private $database;

    /**
     * Constructeur de la classe Articles
     *
     * @param string $host
     * @param string $dbname
     * @param string $user
     * @param string $pass
     *
     * @return void
     */
    public function __construct($host, $dbname, $user, $pass) 
    {
        try {
            $this->database = new PDO('mysql:host=' . $host . ';dbname=' . $dbname, $user, $pass);
            $this->database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            error_log('Erreur de connexion: ' . $e->getMessage());
        }
    public function __construct($host, $dbname, $user, $pass) 
    {
        try {
            $this->database = new PDO('mysql:host=' . $host . ';dbname=' . $dbname, $user, $pass);
            $this->database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            error_log('Erreur de connexion: ' . $e->getMessage());
        }
    } // end of __construct()

    /**
     * Fonction qui permet de récupérer le dernier article dans la base de données
     *
     * @return array
     */
    public function getLastArticle() 
    {
        $query = 'SELECT * FROM posts ORDER BY last_modified DESC LIMIT 1';
        $stmt = $this->database->prepare($query);

    /**
     * Fonction qui permet de récupérer le dernier article dans la base de données
     *
     * @return array
     */
    public function getLastArticle() 
    {
        $query = 'SELECT * FROM posts ORDER BY last_modified DESC LIMIT 1';
        $stmt = $this->database->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Fonction qui permet de récupérer tous les articles dans la base de données
     *
     * @return array
     */
    public function getAllArticles() 
    {
        $query = 'SELECT * FROM posts ORDER BY last_modified DESC';
        $stmt = $this->database->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Fonction qui permet de récupérer un nombre spécifique d'article dans la base de données
     *
     * @return array
     */
    public function getRecentArticles($limit)
    {
        $query = "SELECT * FROM posts ORDER BY last_modified DESC LIMIT :limit";
        $stmt = $this->database->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Fonction qui permet de récupérer un article aléatoire dans la base de données
     *
     * @return array
     */
    public function getRandomArticle() 
    {
        $query = 'SELECT * FROM posts ORDER BY RAND() LIMIT 1';
        $result = $this->database->query($query);
        return $result->fetch();
    }
} // end class Articles
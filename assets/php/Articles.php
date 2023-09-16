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
    } // end __construct()

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

    /**
     * Fonction qui permet de récupérer le top 5 des articles les plus commentés dans la base de données
     *
     * @return array
     */
    public function getMostCommentedArticles($limit = 5)
    {
        $query = 'SELECT posts.*, COUNT(comments.id) AS comment_count
                 FROM posts
                 LEFT JOIN comments ON posts.id = comments.post_id
                 GROUP BY posts.id
                 ORDER BY comment_count DESC
                 LIMIT :limit';

        $stmt = $this->database->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère un article en fonction du slug donné.
     *
     * @param string $slug Le slug de l'article à récupérer.
     * @return array|null Les détails de l'article ou null si non trouvé.
     */
    public function getArticleBySlug($slug)
    {
        $query = "SELECT * FROM posts WHERE slug = :slug LIMIT 1";
        $stmt = $this->database->prepare($query);
        $stmt->bindParam(':slug', $slug, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère tous les commentaires d'un article spécifié par son article_id.
     *
     * @param int $articleId L'ID de l'article pour lequel récupérer les commentaires.
     * @return array Les commentaires de l'article.
     */
    public function getCommentsByArticleId($articleId) {
        $query = "SELECT comments.content AS comment_content, comments.created_at AS comment_date, users.username AS user_name 
                  FROM comments 
                  JOIN users ON comments.author_id = users.id 
                  WHERE comments.post_id = :articleId AND comments.approved = 1
                  ORDER BY comments.created_at DESC";
        $stmt = $this->database->prepare($query);
        $stmt->bindParam(':articleId', $articleId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère l'auteur d'un article spécifié par son id.
     *
     * @param int $userId L'ID de l'auteur pour lequel récupéré les informations.
     * @return array Les informations de l'auteur.
     */
    public function getAuthorById($userId) {
        try {
            // Préparez la requête SQL pour récupérer l'ID de l'auteur de l'article
            $stmt = $this->database->prepare("SELECT users.* FROM users WHERE users.id = :userId");
            
            $stmt->bindParam(":userId", $userId);
            $stmt->execute();

            // Récupérez l'enregistrement de l'utilisateur (auteur)
            $author = $stmt->fetch(PDO::FETCH_ASSOC);

            return $author;
        } catch(PDOException $e) {
            // Gérer les erreurs (à améliorer selon vos besoins)
            echo "Erreur: " . $e->getMessage();
            return null;
        }
    }
} // end class Articles
<?php
require '../../vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__.'/../../');
$dotenv->load();

// Démarrage de la session
session_start();

// Connexion à la base de données
$host = $_ENV['DB_HOST'];
$username = $_ENV['DB_USER'];
$password = $_ENV['DB_PASS'];
$dbname = $_ENV['DB_NAME'];

if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] === "POST") {

    // Vérifiez si l'utilisateur est connecté
    if (isset($_SESSION['id'])) {
        $comment = $userId = "";

        if (isset($_POST["comment-message"]) && isset($_POST["post-id"])) {
            $comment = secureInput($_POST["comment-message"]);
            $postId = secureInput($_POST["post-id"]);
        } else {
            echo json_encode(['success' => false, 'message' => "Une erreur est survenue, veuillez réessayer."]);
        }

        // Insérer le commentaire dans la base de données
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $userId = $_SESSION['id'];

        $stmt = $conn->prepare("INSERT INTO comments (author_id, content, post_id) VALUES (:user_id, :comment_text, :post_id)");

        $stmt->bindParam(':user_id', $_SESSION['id']);
        $stmt->bindParam(':comment_text', $comment);
        $stmt->bindParam(':post_id', $postId);

        $stmt->execute();

        echo json_encode(['success' => true, 'message' => "Commentaire ajouté avec succès, il est désormais en cours de vérification !"]);

    } else {
        echo json_encode(['success' => false, 'message' => "Vous devez être connecté pour publier un commentaire."]);
    }

};

function secureInput(String $data) : string {
    $data = trim($data);               // Supprime les espaces inutiles
    $data = strip_tags($data);         // Supprime les balises HTML et PHP
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8'); // Convertit les caractères spéciaux en entités HTML
    return $data;
}
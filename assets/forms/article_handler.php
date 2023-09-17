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

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        switch ($action) {
            case 'addArticle':
                addArticle($conn);
                break;
            case 'modifyArticle':
                $title = secureInput($_POST['title']);
                $chapo = secureInput($_POST['chapo']);
                $content = secureInput($_POST['content']);
                $articleId = secureInput($_POST['article_id']);
            
                $stmt = $conn->prepare("UPDATE posts SET title = :title, chapo = :chapo, content = :content WHERE id = :article_id");
                $stmt->bindParam(':title', $title);
                $stmt->bindParam(':chapo', $chapo);
                $stmt->bindParam(':content', $content);
                $stmt->bindParam(':article_id', $articleId);
            
                if ($stmt->execute()) {
                    echo json_encode(['success' => true, 'message' => 'Article modifié avec succès!']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Erreur lors de la modification de l\'article.']);
                }
                break; 
            case 'fetch_article':
                if (isset($_POST['article_id'])) {
                    $articleId = intval($_POST['article_id']); // Convertir en entier pour éviter les injections SQL
            
                    $stmt = $conn->prepare("SELECT * FROM posts WHERE id = :article_id");
                    $stmt->bindParam(':article_id', $articleId);
            
                    if ($stmt->execute()) {
                        $article = $stmt->fetch(PDO::FETCH_ASSOC);
                        if ($article) {
                            echo json_encode(['success' => true, 'article' => $article]);
                        } else {
                            echo json_encode(['success' => false, 'message' => 'Article non trouvé.']);
                        }
                    } else {
                        echo json_encode(['success' => false, 'message' => 'Erreur lors de la récupération des données de l\'article.']);
                    }
                } else {
                    echo json_encode(['success' => false, 'message' => 'ID de l\'article non spécifié.']);
                }
                break;    

            case 'delete_article':
                if (isset($_POST['article_id'])) {
                    $articleId = $_POST['article_id'];
            
                    $stmt = $conn->prepare("DELETE FROM posts WHERE id = :article_id");
                    $stmt->bindParam(':article_id', $articleId);
            
                    if ($stmt->execute()) {
                        echo json_encode(['success' => true, 'message' => 'Article supprimé avec succès.']);
                    } else {
                        echo json_encode(['success' => false, 'message' => 'Erreur lors de la suppression de l\'article.']);
                    }
                } else {
                    echo json_encode(['success' => false, 'message' => 'ID de l\'article manquant.']);
                }
                break;  
            case 'disapproved_comment':
                if (isset($_POST['option'])) {
                    $commentId = secureInput($_POST['option']);
            
                    if (deleteComment($commentId, $conn)) {
                        echo json_encode(['success' => true, 'message' => 'Commentaire supprimé avec succès.']);
                    } else {
                        echo json_encode(['success' => false, 'message' => 'Erreur lors de la suppression du commentaire.']);
                    }
                } else {
                    echo json_encode(['success' => false, 'message' => 'ID du commentaire manquant.']);
                }
                break;
            case 'approved_comment':
                if (isset($_POST['option'])) {
                    $commentId = secureInput($_POST['option']);
            
                    if (approveComment($commentId, $conn)) {
                        echo json_encode(['success' => true, 'message' => 'Commentaire approuvé avec succès.']);
                    } else {
                        echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'approbation du commentaire.']);
                    }
                } else {
                    echo json_encode(['success' => false, 'message' => 'ID du commentaire manquant.']);
                }
                break;    
            default:
                echo json_encode(['success' => false, 'message' => 'Action non reconnue.']);
                break;
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Aucune action spécifiée.']);
    }

} catch(PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Erreur de connexion à la base de données.']);
}

function addArticle(PDO $conn) : void {
    if (isset($_SESSION) && isset($_SESSION['id'])) {

        $userInfos = $conn->prepare("SELECT * FROM users WHERE id = :id");
        $userInfos->bindParam(':id', $_SESSION['id']);
        $userInfos->execute();
        $userInfos = $userInfos->fetch(PDO::FETCH_ASSOC);

        if ($userInfos['role'] != 'admin') {
            echo json_encode(['success' => false, 'message' => 'Vous devez être connecté en tant qu\'administrateur pour ajouter un article.']);
            return;
        }

        if (isset($_POST['titre']) && isset($_POST['chapo']) && isset($_POST['contenu'])) {

            $title = secureInput($_POST['titre']);
            $chapo = secureInput($_POST['chapo']);
            $content = secureInput($_POST['contenu']);

        } else {
            echo json_encode(['success' => false, 'message' => 'Veuillez remplir tous les champs.']);
        }

        $author = $_SESSION['id'];
        $slug = generateSlug($title);

        $stmt = $conn->prepare("INSERT INTO posts (title, chapo, content, author_id, slug) VALUES (:title, :chapo, :content, :author_id, :slug)");
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':chapo', $chapo);
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':author_id', $author);
        $stmt->bindParam(':slug', $slug);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Article ajouté avec succès!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'ajout de l\'article.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Vous devez être connecté en tant qu\'administrateur pour ajouter un article.']);
    }
}

function deleteComment(Int $commentId, PDO $connection) : bool {
    try {
        $stmt = $connection->prepare("DELETE FROM comments WHERE id = :id");
        $stmt->bindParam(":id", $commentId);
        $stmt->execute();
        return true;  // Commentaire supprimé avec succès
    } catch (Exception $e) {
        return false;
    }
}

function approveComment(Int $commentId, PDO $connection) : bool {
    try {
        $stmt = $connection->prepare("UPDATE comments SET approved = 1 WHERE id = :id");
        $stmt->bindParam(":id", $commentId);
        $stmt->execute();
        return true;  // Commentaire approuvé avec succès
    } catch (Exception $e) {
        return false;
    }
}

function secureInput(String $data) : string {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function generateSlug(String $string) : string {
    $slug = strtolower($string);
    // Remplace les caractères non alphanumériques par des tirets
    $slug = preg_replace('/[^a-z0-9]+/i', '-', $slug);
    // Supprime les tirets du début et de la fin
    $slug = trim($slug, '-');
    return $slug;
}
?>

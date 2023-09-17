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

$conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] === "POST") {

    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'login':
                $email = secureInput($_POST['email']);
                $password = secureInput($_POST['password']);

                $stmt = $conn->prepare("SELECT id, password FROM users WHERE email = :email");
                $stmt->bindParam(':email', $email);
                $stmt->execute();

                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($user && password_verify($password, $user['password'])) {
                    $_SESSION['id'] = $user['id'];
                    echo json_encode(['success' => true, 'message' => 'Connexion réussie!']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'wrongpassword']);
                }
                break;

            case 'register':
                $email = secureInput($_POST['email']);
                $password = password_hash(secureInput($_POST['password']), PASSWORD_DEFAULT);
                $name = secureInput($_POST['username']);
                
                // Vérifier si le nom d'utilisateur est déjà pris
                $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username");
                $stmt->bindParam(':username', $name);
                $stmt->execute();
                
                if ($stmt->rowCount() > 0) {
                    echo json_encode(['success' => false, 'message' => 'useralreadyexists']);
                    break;
                }
                
                // Vérifier si l'adresse e-mail est déjà utilisée
                $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
                $stmt->bindParam(':email', $email);
                $stmt->execute();
                
                if ($stmt->rowCount() > 0) {
                    echo json_encode(['success' => false, 'message' => 'emailalreadyused']);
                    break;
                }
                
                // Si tout va bien, insérer le nouvel utilisateur
                $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
                $stmt->bindParam(':username', $name);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':password', $password);
                
                if ($stmt->execute()) {
                    echo json_encode(['success' => true, 'message' => 'Inscription réussie!']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'inscription.']);
                }
                break;

                case 'logout':
                    session_destroy();
                    echo json_encode(['success' => true, 'message' => 'Déconnexion réussie!']);
                    break;    

            default:
                echo json_encode(['success' => false, 'message' => 'Action non reconnue.']);
                break;
        }
    }
}

function secureInput(String $data) : string {
    $data = trim($data);               // Supprime les espaces inutiles
    $data = strip_tags($data);         // Supprime les balises HTML et PHP
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8'); // Convertit les caractères spéciaux en entités HTML
    return $data;
}

?>

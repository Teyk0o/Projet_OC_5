<?php
require '../../vendor/autoload.php';

<<<<<<< HEAD
=======
use Dotenv\Dotenv;

>>>>>>> feature/LandingPage
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

<<<<<<< HEAD
=======
$dotenv = Dotenv::createImmutable(__DIR__.'/../../');
$dotenv->load();

>>>>>>> feature/LandingPage
if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] === "POST") {
    $first_name = $last_name = $email = $subject = $message = "";

    if (isset($_POST['nonce']) && $_POST['nonce'] === $_SESSION['nonce'] && isset($_POST["first_name"]) && isset($_POST["last_name"]) && isset($_POST["email"]) && isset($_POST["subject"]) && isset($_POST["message"])) {
        $first_name = cleanVariable($_POST["first_name"]);
        $last_name = cleanVariable($_POST["last_name"]);
        $email = cleanVariable($_POST["email"]);
        $subject = cleanVariable($_POST["subject"]);
        $message = cleanVariable($_POST["message"]);
    } else {
        echo json_encode(['success' => false, 'message' => "Une erreur est survenue, veuillez réessayer."]);
    }

    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $mail->isSMTP();
<<<<<<< HEAD
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'theo.openclassrooms@gmail.com';
        $mail->Password   = 'fkovrfqvsuovirfy';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Recipients
        $mail->setFrom($email, $first_name.' '.$last_name);
        $mail->addAddress('theo.openclassrooms@gmail.com', 'Théo Vilain');
=======
        $mail->Host       = $_ENV['SMTP_HOST'];
        $mail->SMTPAuth   = true;
        $mail->Username   = $_ENV['SMTP_USERNAME'];
        $mail->Password   = $_ENV['SMTP_PASSWORD'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = $_ENV['SMTP_PORT'];

        // Recipients
        $mail->setFrom($email, $first_name.' '.$last_name);
        $mail->addAddress($_ENV['SMTP_USERNAME'], 'Théo Vilain');
>>>>>>> feature/LandingPage

        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $message;

        $mail->send();
        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'message' => "Le mail a bien été envoyé."]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => "Une erreur est survenue, veuillez réessayer."]);
    } // end try catch
}

<<<<<<< HEAD
    /**
     * Fonction qui permet de nettoyer les variables
     *
     * @return variable
     */
} // end try catch
}

    /**
     * Fonction qui permet de nettoyer les variables
     *
     * @return variable
     */

=======
/**
* Fonction qui permet de nettoyer les variables
*
* @return variable
*/
>>>>>>> feature/LandingPage
function cleanVariable($input) 
{
    $input = htmlspecialchars($input, ENT_QUOTES, 'utf-8');
    $input = strip_tags($input);
    return $input;
<<<<<<< HEAD
}
{
    $input = htmlspecialchars($input, ENT_QUOTES, 'utf-8');
    $input = strip_tags($input);
    return $input;
=======
>>>>>>> feature/LandingPage
}
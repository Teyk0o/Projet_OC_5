
<?php
require '../../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $email = $_POST["email"];
    $subject = $_POST["subject"];
    $message = $_POST["message"];

    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'theo.openclassrooms@gmail.com';
        $mail->Password   = 'fkovrfqvsuovirfy';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        //Recipients
        $mail->setFrom($email, $first_name . ' ' . $last_name);
        $mail->addAddress('theo.openclassrooms@gmail.com', 'Théo Vilain');

        //Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $message;

        $mail->send();
        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'message' =>  "Le mail a bien été envoyé."]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' =>  "Une erreur est survenue, veuillez réessayer."]);
    }
}
?>

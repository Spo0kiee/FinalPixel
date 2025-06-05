<?php
// Fehleranzeige aktivieren (nur in der Entwicklung)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Autoloader von Composer einbinden
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

try {
    // Servereinstellungen
    $mail->isSMTP();
    $mail->Host       = 'sandbox.smtp.mailtrap.io';           // SMTP-Server (z.B. Gmail)
    $mail->SMTPAuth   = true;
    $mail->Username   = '8593ddfdfa2ffa';      // Deine E-Mail-Adresse
    $mail->Password   = 'fb70917cc232cd';            // Dein App-Passwort
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    // Absender und Empfänger
    $mail->setFrom('your-mailtrap-email@domain.com', 'FinalPixel Corporate'); // Absender
    $mail->addAddress('lukiano11@gmail.com');         // Zieladresse

    // Inhalt der E-Mail
    $mail->isHTML(true);
    $mail->Subject = 'Test-Mail von PHPMailer';
    $mail->Body    = 'Dies ist eine <b>Test-Mail</b> von PHPMailer.';

    $mail->send();
    echo 'Mail wurde gesendet!';
} catch (Exception $e) {
    echo "Mail konnte nicht gesendet werden. Fehler: {$mail->ErrorInfo}";
}
?>
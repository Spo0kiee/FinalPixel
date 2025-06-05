<?php
session_start();
require_once 'db_connect.php';
require 'vendor/autoload.php'; // Ensure PHPMailer is autoloaded

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $method = $_POST['method'];
    $bestellnummer = $_POST['bestellnummer'];

    // Update the order status in the database
    $stmt = $conn->prepare("UPDATE bestellungen SET Zahlungsstatus = 'Bezahlt', Zahlungsmethode = ? WHERE Bestellnummer = ?");
    $stmt->bind_param("si", $method, $bestellnummer);
    $stmt->execute();
    $stmt->close();

    // Fetch the order details
    $stmt = $conn->prepare("SELECT b.Bestellnummer, b.Bestelldatum, bd.Menge, p.Name, p.Preis, k.Email 
                            FROM bestellungen b
                            JOIN bestellungsdetails bd ON b.Bestellnummer = bd.Bestellnummer
                            JOIN produkte p ON bd.Artikelnummer = p.Artikelnummer
                            JOIN kunden k ON b.Kundennummer = k.Kundennummer
                            WHERE b.Bestellnummer = ?");
    $stmt->bind_param("i", $bestellnummer);
    $stmt->execute();
    $result = $stmt->get_result();
    $bestellung = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    // Send confirmation email using PHPMailer
    $to = $bestellung[0]['Email'];
    $subject = "Bestellbestatigung - FinalPixel";
    $message = "Danke für Ihren Einkauf bei FinalPixel!\n\n";
    $message .= "Bestellnummer: " . $bestellnummer . "\n";
    $message .= "Bestelldatum: " . $bestellung[0]['Bestelldatum'] . "\n\n";
    $message .= "Bestelldetails:\n";
    foreach ($bestellung as $item) {
        $message .= $item['Name'] . " - Menge: " . $item['Menge'] . " - Preis: " . number_format($item['Preis'], 2) . " €\n";
    }
    $message .= "\nGesamt: " . number_format(array_sum(array_column($bestellung, 'Preis')), 2) . " €\n";

    $mail = new PHPMailer(true);

    try {
        // SMTP settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'finalpixelco@gmail.com';
        $mail->Password   = 'mqbe bgfh eqdp sapl';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Sender and recipient
        $mail->setFrom('finalpixelco@gmail.com', 'FinalPixel Corporate');
        $mail->addAddress($to);

        // Email content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = nl2br($message);
        $mail->AltBody = $message;

        $mail->send();
        echo "success";
    } catch (Exception $e) {
        echo "Email sending failed. Error: {$mail->ErrorInfo}";
        error_log("Email sending failed to $to with subject $subject. Error: {$mail->ErrorInfo}");
    }
}
?>
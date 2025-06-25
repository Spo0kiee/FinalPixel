<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Registrierung</title>
    <link rel="stylesheet" href="Styles.css" type="text/css" />
    <style>
        body {
            background-image: url('http://localhost/FinalPixel/pictures/Background Register_Front.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: Arial, sans-serif;
            color: white;
            overflow: hidden;
        }
    </style>
</head>
<body>
<?php
// Fehleranzeige aktivieren (nur in der Entwicklung)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// PHPMailer einbinden (über Composer)
require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Datenbankverbindung herstellen
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "finalpixel";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Verbindung fehlgeschlagen: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $adresse = trim($_POST['adresse']);
    $email = trim($_POST['email']);
    $passwort = trim($_POST['passwort']);

   
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Ungültige E-Mail-Adresse!");
    }

    // Passwort hashen
    $hashed_password = password_hash($passwort, PASSWORD_BCRYPT);

    // Bestätigungstoken generieren und Status auf 1 setzen (aktiv)
    $token = md5(uniqid(rand(), true));
    $active = 0;

    // SQL-Statement mit Prepared Statement
    $stmt = $conn->prepare("INSERT INTO kunden (name, adresse, email, passwort, confirm_token, active) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssi", $name, $adresse, $email, $hashed_password, $token, $active);

    if ($stmt->execute()) {
        // Bestätigungslink erstellen
        $confirmLink = "http://localhost/FinalPixel/confirm.php?token=" . $token;

        $mail = new PHPMailer(true);

        try {
            // SMTP-Einstellungen (Beispiel mit Mailtrap – passe diese bei Bedarf an)
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';  // -SMTP-Server
            $mail->SMTPAuth   = true;
            $mail->Username   = 'finalpixelco@gmail.com';  // -Username
            $mail->Password   = 'mqbe bgfh eqdp sapl';   // -Passwort
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            // Absender und Empfänger
            $mail->setFrom('finalpixelco@gmail.com.com', 'FinalPixel Corporate');
            $mail->addAddress($email, $name);

            // E-Mail Inhalt
            $mail->isHTML(true);
            $mail->Subject = 'Registrierungsbestatigung fur FinalPixel';
            $mail->Body    = "Hallo $name,<br><br>bitte bestatige deine Registrierung, indem du auf folgenden Link klickst:<br><a href='$confirmLink'>$confirmLink</a><br><br>Viele Gruse,<br>FinalPixel Team";
            $mail->AltBody = "Hallo $name,\n\nbitte bestatige deine Registrierung, indem du auf folgenden Link klickst:\n$confirmLink\n\nViele Gruee,\nFinalPixel Team";

            $mail->send();
            // Nach erfolgreichem Versand: Weiterleiten zur Login-Seite
            header("Location: login.php");
            exit();
        } catch (Exception $e) {
            echo "Registrierung erfolgreich, aber die Bestätigungs-Mail konnte nicht gesendet werden. Fehler: {$mail->ErrorInfo}";
        }
    } else {
        echo "Fehler bei der Registrierung: " . $stmt->error;
    }
    $stmt->close();
}

$conn->close();
?>
    <div class="registration-container">
        <h1>Registrieren</h1>
        <form action="Registrierung.php" method="post">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required><br>
            <label for="adresse">Address:</label>
            <input type="text" id="adresse" name="adresse" required><br>
            <label for="email">E-Mail:</label>
            <input type="email" id="email" name="email" required><br>
            <label for="passwort">Password:</label>
            <input type="password" id="passwort" name="passwort" required><br>
            <input type="submit" name="register" value="Registration">
        </form>
        <!-- Optional: Blinkende Lichter als Dekoration -->
        <div class="blink" style="margin-top: 20px; font-size: 24px;">
            <img src="http://localhost/FinalPixel/pictures/FinalPixel Logo.png" alt="FinalPixel Logo" class="logo" width="100">
        </div>
        <a href="FinalPixel Startseite.html" class="back-button">Zurück</a>
    </div>
</body>
</html>
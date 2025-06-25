<?php
session_start();

// Fehleranzeige aktivieren (nur in der Entwicklung)
error_reporting(E_ALL);
ini_set('display_errors', 1);

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
    $email = trim($_POST['email']);
    $passwort = trim($_POST['passwort']);

    // E-Mail-Validierung
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Ungültige E-Mail-Adresse!");
    }

    // Benutzer anhand der E-Mail-Adresse abfragen
    $stmt = $conn->prepare("SELECT Kundennummer, Name, Passwort, active FROM kunden WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $name, $hashed_password, $active);
        $stmt->fetch();

        // Überprüfen, ob das Konto aktiviert ist
        if ($active == 0) {
            die("Bitte bestätige deine Registrierung, bevor du dich einloggst.");
        }

        // Passwort überprüfen
        if (password_verify($passwort, $hashed_password)) {
            // Login erfolgreich
            $_SESSION['userid'] = $id;
            $_SESSION['username'] = $name;
            header("Location: Startseite.php");
            exit();
        } else {
            echo "Falsches Passwort!";
        }
    } else {
        echo "Benutzer nicht gefunden!";
    }
    $stmt->close();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Login - FinalPixel</title>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600&display=swap" rel="stylesheet">
    <div class="blink" style="margin-top: 20px; font-size: 24px;"> 
        <img src="http://localhost/FinalPixel/pictures/FinalPixel Logo.png" 
        alt="FinalPixel Logo" class="logo" width="200">
    </div>
    
    
<style>
body {
    background-image: url('http://localhost/FinalPixel/pictures/Background Register_Front.jpg');
    background-size: cover;
    background-position: center;
    margin: 0;
    padding: 0;
    height: 100vh;
    font-family: 'Cinzel', serif;
    color: #f5f5f5;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}

h1 {
    font-size: 3rem;
    text-shadow: 2px 2px 5px black;
    color: #FFD700;
    margin-bottom: 20px;
    animation: fadeIn 2s ease-in-out;
}

.registration-container {
    background: rgba(15, 15, 15, 0.85);
    padding: 40px 50px;
    border-radius: 20px;
    text-align: center;
    max-width: 400px;
    width: 100%;
    box-shadow: 0 0 20px rgba(255, 215, 0, 0.4);
    border: 2px solid #FFD700;
    animation: fadeIn 1.5s ease-in-out;
}

input[type="email"],
input[type="password"] {
    width: 100%;
    padding: 12px;
    margin: 12px 0;
    border: none;
    border-radius: 8px;
    background: rgba(255, 255, 255, 0.9);
    font-family: Arial, sans-serif;
    font-size: 1rem;
    color: #333;
    box-shadow: inset 0 0 5px rgba(0,0,0,0.2);
}

input[type="submit"] {
    background-color: #b8860b;
    color: white;
    padding: 12px 24px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.2s ease;
    font-size: 1rem;
    font-weight: bold;
}

input[type="submit"]:hover {
    background-color: #daa520;
    transform: scale(1.05);
}

.back-button {
    background-color: #6b4226;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    margin-top: 20px;
    text-decoration: none;
    font-weight: bold;
}

.back-button:hover {
    background-color: #8b5a2b;
}

p a {
    color: #87cefa;
    text-decoration: none;
}

p a:hover {
    text-decoration: underline;
}

/* Fix: opacity comma issue */
@keyframes blink {
    0%, 100% {
        opacity: 1;
    }
    50% {
        opacity: 0.5;
    }
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

</style>
</head>


<body>
    <h1>Login</h1>
    <form action="login.php" method="post">
        <label for="email">E-Mail:</label>
        <input type="email" id="email" name="email" required><br>
        
        <label for="passwort">Passwort:</label>
        <input type="password" id="passwort" name="passwort" required><br>

        <input type="submit" name="login" value="Login">
    </form>
    
    <p>Kein Konto? <a href="Registrierung.php" style="color: #007BFF;">Registriere jetzt!</a></p>
    <a href="FinalPixel Startseite.html" class="back-button">Zurück</a>
</body>
</html>


<?php
session_start();

// Fehleranzeige aktivieren – **nur während der Entwicklung verwenden**
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Verbindung zur MySQL-Datenbank herstellen
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "finalpixel";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verbindung prüfen
if ($conn->connect_error) {
    die("Verbindung fehlgeschlagen: " . $conn->connect_error);
}

// Wenn das Formular über POST gesendet wurde
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Eingaben aus dem Formular holen und trimmen
    $currentPassword = trim($_POST['current-password']);
    $newPassword = trim($_POST['new-password']);
    $confirmPassword = trim($_POST['confirm-password']);
    $userId = $_SESSION['userid']; // Benutzer-ID aus der Session lesen

    // Prüfen, ob die neuen Passwörter übereinstimmen
    if ($newPassword !== $confirmPassword) {
        die("Die neuen Passwörter stimmen nicht überein!");
    }

    // Aktuelles (gehashtes) Passwort aus der Datenbank holen
    $stmt = $conn->prepare("SELECT Passwort FROM kunden WHERE Kundennummer = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->bind_result($hashedPassword);
    $stmt->fetch();
    $stmt->close();

    // Überprüfen, ob das eingegebene aktuelle Passwort korrekt ist
    if (!password_verify($currentPassword, $hashedPassword)) {
        die("Das aktuelle Passwort ist falsch!");
    }

    // Neues Passwort mit BCRYPT hashen
    $newHashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

    // Neues Passwort in der Datenbank speichern
    $stmt = $conn->prepare("UPDATE kunden SET Passwort = ? WHERE Kundennummer = ?");
    $stmt->bind_param("si", $newHashedPassword, $userId);

    // Erfolg oder Fehler anzeigen
    if ($stmt->execute()) {
        echo "Passwort erfolgreich geändert!";
    } else {
        echo "Fehler beim Aktualisieren des Passworts: " . $stmt->error;
    }

    $stmt->close();
}

// Verbindung schließen
$conn->close();
?>

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
    $currentPassword = trim($_POST['current-password']);
    $newPassword = trim($_POST['new-password']);
    $confirmPassword = trim($_POST['confirm-password']);
    $userId = $_SESSION['userid']; // Assuming you have the user ID stored in the session

    if ($newPassword !== $confirmPassword) {
        die("New passwords do not match!");
    }

    // Fetch the current password from the database
    $stmt = $conn->prepare("SELECT Passwort FROM kunden WHERE Kundennummer = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->bind_result($hashedPassword);
    $stmt->fetch();
    $stmt->close();

    // Verify the current password
    if (!password_verify($currentPassword, $hashedPassword)) {
        die("Current password is incorrect!");
    }

    // Hash the new password
    $newHashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

    // Update the password in the database
    $stmt = $conn->prepare("UPDATE kunden SET Passwort = ? WHERE Kundennummer = ?");
    $stmt->bind_param("si", $newHashedPassword, $userId);

    if ($stmt->execute()) {
        echo "Password changed successfully!";
    } else {
        echo "Error updating password: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
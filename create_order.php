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

$kundennummer = $_SESSION['userid'] ?? null;
$cart = $_SESSION['cart'] ?? [];

if ($kundennummer && !empty($cart)) {
    // Generate a unique Bestellnummer
    $stmt = $conn->prepare("INSERT INTO bestellungen (Kundennummer, Bestelldatum) VALUES (?, NOW())");
    $stmt->bind_param("i", $kundennummer);
    $stmt->execute();
    $bestellnummer = $stmt->insert_id;
    $stmt->close();

    // Insert order items into the bestellungsdetails table
    foreach ($cart as $artikelnummer => $menge) {
        $stmt = $conn->prepare("INSERT INTO bestellungsdetails (Bestellnummer, Artikelnummer, Menge) VALUES (?, ?, ?)");
        $stmt->bind_param("iii", $bestellnummer, $artikelnummer, $menge);
        $stmt->execute();
        $stmt->close();
    }

    // Clear the cart
    unset($_SESSION['cart']);

    // Redirect to the payment methods page
    header("Location: zahlungsmethoden.php?Bestellnummer=$bestellnummer");
    exit();
} else {
    die("Kundennummer oder Warenkorb ist leer.");
}

$conn->close();
?>
<?php
session_start();

// Überprüfen, ob die Artikelnummer übergeben wurde
if (!isset($_POST['Artikelnummer'])) {
    die("Kein Produkt ausgewählt.");
}

$artikelnummer = $_POST['Artikelnummer'];

// Überprüfen, ob der Warenkorb bereits existiert
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Produkt zum Warenkorb hinzufügen
if (!isset($_SESSION['cart'][$artikelnummer])) {
    $_SESSION['cart'][$artikelnummer] = 1; // Anzahl auf 1 setzen
} else {
    $_SESSION['cart'][$artikelnummer]++; // Anzahl erhöhen
}

// Weiterleitung zurück zur Produktseite oder Startseite
header("Location: produkt.php?artikelnummer=" . $artikelnummer);
exit();
?>
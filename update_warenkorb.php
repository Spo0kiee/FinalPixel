<?php
session_start(); // Sitzung starten, um auf den Warenkorb (Session-Daten) zugreifen zu können

// Prüfen, ob notwendige POST-Daten vorhanden sind
if (!isset($_POST['action']) || !isset($_POST['artikelnummer'])) {
    die("Ungültige Anfrage."); // Abbrechen, wenn etwas fehlt
}

$action = $_POST['action']; // Die gewünschte Aktion (add, remove, delete)
$artikelnummer = $_POST['artikelnummer']; // Die Artikelnummer, auf die sich die Aktion bezieht

// Wenn der Warenkorb noch nicht existiert, initialisieren wir ihn als leeres Array
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Je nach Aktion wird unterschiedlich auf den Warenkorb zugegriffen
switch ($action) {
    case 'add': // Artikel hinzufügen
        if (!isset($_SESSION['cart'][$artikelnummer])) {
            // Wenn Artikel noch nicht im Warenkorb, mit Menge 1 hinzufügen
            $_SESSION['cart'][$artikelnummer] = 1;
        } else {
            // Sonst Menge um 1 erhöhen
            $_SESSION['cart'][$artikelnummer]++;
        }
        break;
    case 'remove': // Einen Artikel verringern
        if (isset($_SESSION['cart'][$artikelnummer])) {
            $_SESSION['cart'][$artikelnummer]--; // Menge verringern
            if ($_SESSION['cart'][$artikelnummer] <= 0) {
                // Wenn Menge 0 oder weniger, Artikel komplett entfernen
                unset($_SESSION['cart'][$artikelnummer]);
            }
        }
        break;
    case 'delete': // Artikel komplett löschen
        if (isset($_SESSION['cart'][$artikelnummer])) {
            unset($_SESSION['cart'][$artikelnummer]);
        }
        break;
    default:
        die("Ungültige Aktion."); // Wenn eine unbekannte Aktion gesendet wird
}

// Nach der Aktion zurück zum Warenkorb weiterleiten
header("Location: warenkorb.php");
exit();
?>

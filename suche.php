<?php
require_once 'db_connect.php';

if (isset($_GET['search'])) {
    $search = trim($_GET['search']);
    $search = "%$search%";

    $stmt = $conn->prepare("SELECT Artikelnummer FROM produkte WHERE Name LIKE ?");
    $stmt->bind_param("s", $search);
    $stmt->execute();
    $stmt->bind_result($artikelnummer);
    $stmt->fetch();
    $stmt->close();

    if ($artikelnummer) {
        header("Location: produkt.php?artikelnummer=" . $artikelnummer);
        exit();
    } else {
        echo "Kein Produkt gefunden.";
    }
} else {
    echo "Keine Suchanfrage eingegeben.";
}
?>
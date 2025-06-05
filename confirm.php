<?php
// Verbindung herstellen
require_once 'db_connect.php';

if (isset($_GET['token'])) {
    $token = $conn->real_escape_string($_GET['token']);
    $sql = "SELECT * FROM kunden WHERE confirm_token='$token' LIMIT 1";
    $result = $conn->query($sql);
    if ($result->num_rows == 1) {
        // Token gefunden – setze Benutzerstatus auf bestätigt
        $sqlUpdate = "UPDATE kunden SET active=1, confirm_token='' WHERE confirm_token='$token'";
        if ($conn->query($sqlUpdate)) {
            echo "Registrierung bestätigt! Du kannst dich jetzt einloggen.";
        } else {
            echo "Fehler beim Bestätigen.";
        }
    } else {
        echo "Ungültiger Bestätigungslink.";
    }
} else {
    echo "Kein Token vorhanden.";
}
?>

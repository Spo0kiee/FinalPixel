<?php
session_start(); // Session starten, um Benutzerinformationen zu speichern

// Fehleranzeige aktivieren (nur in der Entwicklungsphase sinnvoll)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Verbindung zur Datenbank herstellen
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "finalpixel";
$conn = new mysqli($servername, $username, $password, $dbname);

// Wenn die Verbindung fehlschlägt, abbrechen
if ($conn->connect_error) {
    die("Verbindung fehlgeschlagen: " . $conn->connect_error);
}

// Bestellnummer aus URL übernehmen, wenn vorhanden
$bestellnummer = $_GET['Bestellnummer'] ?? null;

// Wenn Bestellnummer vorhanden ist, Bestelldetails abfragen
if ($bestellnummer) {
    // SQL-Statement vorbereiten, um Daten aus mehreren Tabellen zu holen
    $stmt = $conn->prepare("SELECT b.Bestellnummer, b.Bestelldatum, bd.Menge, p.Name, p.Preis 
                            FROM bestellungen b
                            JOIN bestellungsdetails bd ON b.Bestellnummer = bd.Bestellnummer
                            JOIN produkte p ON bd.Artikelnummer = p.Artikelnummer 
                            WHERE b.Bestellnummer = ?");
    $stmt->bind_param("i", $bestellnummer);
    $stmt->execute();
    $result = $stmt->get_result();
    $bestellung = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
} else {
    die("Bestellnummer nicht angegeben."); // Abbrechen, wenn keine Nummer vorhanden ist
}

// Verbindung beenden
$conn->close();
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Zahlungsmethoden</title>
    <link rel="stylesheet" href="Styles.css" type="text/css" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
</head>    
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-image: url(http://localhost/FinalPixel/pictures/medieval_background.jpg);
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
        background-attachment: fixed;
        color: #130e0e;
        scroll-behavior: smooth;
    }
</style>
<body>
<header>
    <?php include 'header.php'; ?> <!-- Gemeinsamer Seitenheader einbinden -->
</header>
    
<div class="container">
    <div class="payment-box">
        <div class="payment-methods">
            <h2>Zahlungsmethoden</h2>
            <ul>
                <!-- Verschiedene Zahlungsmethoden -->
                <li><button onclick="selectPaymentMethod('PayPal')">PayPal</button></li>
                <li><button onclick="selectPaymentMethod('Kreditkarte')">Kreditkarte</button></li>
                <li><button onclick="selectPaymentMethod('Überweisung')">Überweisung</button></li>
            </ul>
        </div>
        <div class="order-summary">
            <h2>Bestelldetails</h2>
            <table>
                <thead>
                    <tr>
                        <th>Produktname</th>
                        <th>Menge</th>
                        <th>Preis</th>
                        <th>Gesamt</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($bestellung as $item): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['Name']); ?></td>
                        <td><?php echo htmlspecialchars($item['Menge']); ?></td>
                        <td><?php echo number_format($item['Preis'], 2); ?> €</td>
                        <td><?php echo number_format($item['Preis'] * $item['Menge'], 2); ?> €</td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <button class="pay-button" id="pay-button">Bezahlen</button>
            <p style="margin-top: 10px; font-size: 14px; color: #666;">
                🔒 Ihre Daten sind sicher – verschlüsselte SSL-Verbindung.
            </p>
        </div>
    </div>
</div>

<script>
// Funktion zur Auswahl der Zahlungsmethode
function selectPaymentMethod(method) {
    // Zulässige Zahlungsmethoden definieren
    const validMethods = ['PayPal', 'Kreditkarte', 'Überweisung'];

    // Ungültige Methode blockieren
    if (!validMethods.includes(method)) {
        alert('Ungültige Zahlungsmethode ausgewählt.');
        return;
    }

    // Sichtbar machen des Bezahl-Buttons und Text setzen
    document.getElementById('pay-button').classList.add('visible');
    document.getElementById('pay-button').innerText = 'Bezahlen mit ' + method;

    // Eventhandler setzen für Button
    document.getElementById('pay-button').onclick = function() {
        // Bestätigung anzeigen
        alert('Bezahlung mit ' + method + ' ausgewählt.');

        // AJAX-Request absenden an Backend (zahlung beenden)
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'zahlungsende.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                alert('Danke für Ihren Einkauf');
                window.location.href = 'Danke.php'; // Zur Dankeseite weiterleiten
            }
        };

        // Daten senden: Zahlungsmethode + Bestellnummer
        xhr.send('method=' + method + '&bestellnummer=' + <?php echo json_encode($bestellnummer); ?>);
    };
}
</script>

<?php include 'footer.php'; ?> <!-- Footer einbinden -->
</body>
</html>

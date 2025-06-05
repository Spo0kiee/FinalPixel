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
$bestellnummer = $_GET['Bestellnummer'] ?? null;
if ($bestellnummer) {
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
    die("Bestellnummer nicht angegeben.");
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Zahlungsmethoden</title>
    <link rel="stylesheet" href="Styles.css" type="text/css" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    
<style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url(http://localhost/FinalPixel/pictures/medieval_background.jpg);
            background-position: center;
            background-size: cover;
            background-repeat: no-repeat;
            height: 100vh;
            color: #130e0e;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

</style>
</head>

<body>
<header>
        <?php include 'header.php'; ?>
</header>
    
<div class="container">
    <div class="payment-box">
        <div class="payment-methods">
        <h2>Zahlungsmethoden</h2>
        <ul>
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

<script>
    function selectPaymentMethod(method) {
        const validMethods = ['PayPal', 'Kreditkarte', 'Überweisung'];
        if (!validMethods.includes(method)) {
            alert('Ungültige Zahlungsmethode ausgewählt.');
            return;
        }
        
        document.getElementById('pay-button').classList.add('visible');
        document.getElementById('pay-button').innerText = 'Bezahlen mit ' + method;
        document.getElementById('pay-button').onclick = function() {
            // Simulate payment process
            alert('Bezahlung mit ' + method + ' ausgewählt.');
            
            // Send AJAX request to complete the payment
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'zahlungsende.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    alert('Danke für Ihren Einkauf');
                    window.location.href = 'Danke.php';
                }
            };
            xhr.send('method=' + method + '&bestellnummer=' + <?php echo json_encode($bestellnummer); ?>);
        };
    }
</script>


<?php include 'footer.php'; ?>
</body>
</html>
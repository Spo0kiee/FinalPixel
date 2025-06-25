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
    $stmt = $conn->prepare("SELECT b.Bestellnummer, b.Bestelldatum, b.Menge, p.Name, p.Preis 
                            FROM bestellungen b
                            JOIN produkte p ON b.Artikelnummer = p.Artikelnummer 
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
    <title>Bestellbestätigung</title>
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

    </style>
</head>
<body>
<link rel="stylesheet" href="Styles.css" type="text/css" />
    <div class="container">
        <div class="confirmation-box">
            <h1>Bestellbestätigung</h1>
            <p>Vielen Dank für Ihre Bestellung! Ihre Bestellnummer ist <strong><?php echo htmlspecialchars($bestellnummer); ?></strong>.</p>
            <a href="zahlungsmethoden.php?Bestellnummer=<?php echo htmlspecialchars($bestellnummer); ?>">Weiter zur Zahlung</a>
            <div class="order-details">
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
            </div>
        </div>
    </div>
</body>
</html>
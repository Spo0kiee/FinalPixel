<?php
session_start();
require_once 'db_connect.php';

if (!isset($_GET['artikelnummer'])) {
    die("Kein Produkt ausgewählt.");
}
$artikelnummer = $conn->real_escape_string($_GET['artikelnummer']);

$sql = "SELECT * FROM Produkte WHERE Artikelnummer='$artikelnummer' LIMIT 1";
$result = $conn->query($sql);

if (!$result || $result->num_rows == 0) {
    die("Produkt nicht gefunden.");
}

$produkt = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($produkt['Name']); ?> - Produktdetails</title>
    <link rel="stylesheet" href="Styles.css" type="text/css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-image: url(http://localhost/FinalPixel/pictures/Background2.jpg);
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
        background-attachment: fixed;
        color: #130e0e;
        scroll-behavior: smooth;

        min-height: 100vh;
        position: relative;
        padding-bottom: 80px; /* Footer-Höhe einrechnen */
    }

    footer {
        position: absolute;
        bottom: 0;
        width: 100%;
        height: 80px;
    }
</style>
<body>
    <header>
        <?php include 'header.php'; ?>
    </header>

    <main>
        <div class="artikel-container">
            <div class="artikel-bild">
                <img src="<?php echo htmlspecialchars($produkt['bild_url']); ?>" alt="<?php echo htmlspecialchars($produkt['Name']); ?>" style="max-width:100%;">
            </div>
            <div class="artikel-daten">
                <h1><?php echo htmlspecialchars($produkt['Name']); ?></h1>
                <p><strong>Preis:</strong> <?php echo number_format($produkt['Preis'], 2); ?> €</p>
                <p><strong>Plattform:</strong> <?php echo htmlspecialchars($produkt['Plattform']); ?></p>
                <p><strong>Key-Typ:</strong> <?php echo htmlspecialchars($produkt['Key_Typ']); ?></p>
                <p><strong>Genre:</strong> <?php echo htmlspecialchars($produkt['Genre']); ?></p>

                <form action="add_to_cart.php" method="post">
                    <input type="hidden" name="Artikelnummer" value="<?php echo htmlspecialchars($produkt['Artikelnummer']); ?>">
                    <button type="submit" class="add-to-cart-button">In den Warenkorb legen</button>
                </form>

                <div class="artikel-beschreibung">
                    <h2>Beschreibung</h2>
                    <p><?php echo nl2br(htmlspecialchars($produkt['Beschreibung'])); ?></p>
                </div>
            </div>
        </div>
    </main>

    <?php include 'footer.php'; ?>
</body>
</html>

<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// Datenbankverbindung herstellen
require_once 'db_connect.php';

$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$produkte = [];
if (!empty($cart)) {
    $artikelnummern = array_keys($cart);
    $placeholders = implode(',', array_fill(0, count($artikelnummern), '?'));
    $stmt = $conn->prepare("SELECT * FROM produkte WHERE Artikelnummer IN ($placeholders)");
    $stmt->bind_param(str_repeat('s', count($artikelnummern)), ...$artikelnummern);
    $stmt->execute();
    $result = $stmt->get_result();
    $produkte = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Warenkorb</title>
    <link rel="stylesheet" href="Styles.css" type="text/css" />
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
        <?php include 'header.php'; ?>
    </header>

    <div class="main-container">
        <div class="cart-container">
            <div class="cart-items">
                <h1>Warenkorb</h1>
                <?php if (empty($produkte)): ?>
                    <p>Ihr Warenkorb ist leer.</p>
                <?php else: ?>
                    <?php foreach ($produkte as $produkt): ?>
                        <div class="cart-item">
                            <img src="<?php echo htmlspecialchars($produkt['bild_url']); ?>" alt="<?php echo htmlspecialchars($produkt['Name']); ?>">
                            <div class="item-details">
                                <h2><?php echo htmlspecialchars($produkt['Name']); ?></h2>
                                <p><?php echo htmlspecialchars($produkt['Beschreibung']); ?></p>
                                <span>Preis: <?php echo number_format($produkt['Preis'], 2); ?> €</span>
                                <div class="quantity-controls">
                                    <form action="update_warenkorb.php" method="post" style="display:inline;">
                                        <input type="hidden" name="artikelnummer" value="<?php echo htmlspecialchars($produkt['Artikelnummer']); ?>">
                                        <input type="hidden" name="action" value="remove">
                                        <button type="submit" class="quantity-btn">-</button>
                                    </form>
                                    <span class="quantity"><?php echo $cart[$produkt['Artikelnummer']]; ?></span>
                                    <form action="update_warenkorb.php" method="post" style="display:inline;">
                                        <input type="hidden" name="artikelnummer" value="<?php echo htmlspecialchars($produkt['Artikelnummer']); ?>">
                                        <input type="hidden" name="action" value="add">
                                        <button type="submit" class="quantity-btn">+</button>
                                    </form>
                                </div>
                                <form action="update_warenkorb.php" method="post" style="display:inline;">
                                    <input type="hidden" name="artikelnummer" value="<?php echo htmlspecialchars($produkt['Artikelnummer']); ?>">
                                    <input type="hidden" name="action" value="delete">
                                    <button type="submit" class="remove-btn">🗑 Entfernen</button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <p class="total"><strong>Gesamtsumme:</strong> 
                        <?php echo number_format(array_sum(array_map(function($produkt) use ($cart) {
                            return $produkt['Preis'] * $cart[$produkt['Artikelnummer']];
                        }, $produkte)), 2); ?> €</p>
                <?php endif; ?>
            </div>

            <div class="right-content">
                <form action="create_order.php" method="post" onsubmit="return validateEmail()">
                    <div class="email-section">
                        <h2>Gib deine E-Mail ein</h2>
                        <p>Gib deine E-Mail ein. Wir brauchen sie, um dir die Bestellung zu schicken.</p>
                        <input type="email" id="email" name="email" placeholder="Deine E-Mail" required>
                    </div>

                    <div class="gift-payment-container">
                        <div class="gift-section">
                            <img src="http://localhost/FinalPixel/pictures/present.png" alt="present">
                            <div>
                                <h2 style="color: #444; font-size: 16px; font-weight: bold;">ALS GESCHENK VERSCHENKEN</h2>
                                <p style="color: #666; font-size: 14px;">
                                    Kaufe ein Produkt und erhalte ein fertig herunterladbares PDF-Geschenk.
                                </p>
                            </div>
                        </div>

                        <div class="payment-section">
                            <img src="http://localhost/FinalPixel/pictures/lock.png" alt="Keypad">
                            <div>
                                <h2 style="color: #444; font-size: 16px; font-weight: bold;">EINFACHE UND SICHERE ZAHLUNGEN</h2>
                                <p style="color: #666; font-size: 14px;">
                                    Visa, Mastercard, PayPal und 30+ mehr
                                </p>
                            </div>
                        </div>
                    </div>

                    <button class="checkout-btn">Weiter zur Zahlung</button>
                    <p class="terms-text">
                        Indem ich auf „Weiter zur Zahlung“ klicke, bestätige ich, dass ich die 
                        <a href="Footer/AGB.html">AGB</a> gelesen und akzeptiert habe.
                    </p>
                </form>
            </div>
        </div>
    </div>

    <script>
        function validateEmail() {
            var email = document.getElementById("email").value;
            if (email === "") {
                alert("Bitte geben Sie eine E-Mail-Adresse ein.");
                return false;
            }
            return true;
        }
    </script>

    <?php include 'footer.php'; ?>
</body>
</html>

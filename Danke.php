<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Danke für Ihren Einkauf</title>
    <link rel="stylesheet" href="Styles.css" type="text/css" />
</head>
<style>
        body {
        font-family: 'Roboto', sans-serif;
        margin: 0;
        padding: 0;
        background-image: url(http://localhost/FinalPixel/pictures/medieval_background.jpg);
        background-position: center;
        background-size: cover;
        background-repeat: no-repeat;
        height: 100vh;
        color:rgb(214, 212, 212);
    }
</style>
<body>
    <header>
        <?php include 'header.php'; ?>
    </header>
    <main>
        <div class="thank-you-container">
            <h1>Danke für Ihren Einkauf!</h1>
            <p>Ihre Bestellung wurde erfolgreich abgeschlossen und eine Bestätigung wurde an Ihre E-Mail-Adresse gesendet.</p>
            <a href="Startseite.php" class="back-button">Zurück zur Startseite</a>
        </div>
    </main>
    <?php include 'footer.php'; ?>
</body>
</html>
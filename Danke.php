<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Danke für Ihren Einkauf</title>
    <link rel="stylesheet" href="Styles.css" type="text/css" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        background-attachment: fixed;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        color: #fff;
        scroll-behavior: smooth;
    }

    main {
        flex: 1;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .thank-you-container {
        background: rgba(0, 0, 0, 0.7);
        padding: 40px;
        border-radius: 16px;
        box-shadow: 0 0 25px rgba(0, 0, 0, 0.5);
        text-align: center;
        max-width: 600px;
        width: 90%;
    }

    .thank-you-container h1 {
        font-size: 32px;
        margin-bottom: 20px;
        color: #ffd700;
    }

    .thank-you-container p {
        font-size: 18px;
        margin-bottom: 30px;
        color: #ddd;
    }

    .back-button {
        display: inline-block;
        padding: 12px 24px;
        background: linear-gradient(to right, #a0522d, #cd853f);
        color: white;
        border: none;
        border-radius: 8px;
        text-decoration: none;
        font-weight: bold;
        transition: background 0.3s ease;
    }

    .back-button:hover {
        background: linear-gradient(to right, #cd853f, #d2b48c);
    }
</style>
<body>
    <header>
        <?php include 'header.php'; ?>
    </header>

    <main>
        <div class="thank-you-container">
            <h1>Danke für Ihren Einkauf!</h1>
            <p>Ihre Bestellung wurde erfolgreich abgeschlossen. Eine Bestätigung ist auf dem Weg zu Ihrer E-Mail-Adresse.</p>
            <a href="Startseite.php" class="back-button">Zurück zur Startseite</a>
        </div>
    </main>

    <?php include 'footer.php'; ?>
</body>
</html>

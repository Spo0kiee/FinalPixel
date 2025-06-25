<?php
require_once 'db_connect.php';

$genre = isset($_GET['genre']) ? $_GET['genre'] : '';

$stmt = $conn->prepare("SELECT * FROM produkte WHERE genre = ?");
$stmt->bind_param("s", $genre);
$stmt->execute();
$result = $stmt->get_result();
$produkte = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Produkte - <?php echo htmlspecialchars($genre); ?></title>
    <link rel="stylesheet" href="Styles.css" type="text/css" />
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500&family=Inter:wght@400;600&display=swap" rel="stylesheet">

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
</head>
<body>
    <header>
        <?php include 'header.php'; ?>
    </header>
    <div class="Produkte-container">
        <h1>Produkte - <?php echo htmlspecialchars($genre); ?></h1>
        <div class="product-grid">
            <?php foreach ($produkte as $produkt): ?>
                <div class="product-item">
                    <a href="produkt.php?artikelnummer=<?php echo htmlspecialchars($produkt['Artikelnummer']); ?>">
                        <img src="<?php echo htmlspecialchars($produkt['bild_url']); ?>" alt="<?php echo htmlspecialchars($produkt['Name']); ?>">
                        <h3><?php echo htmlspecialchars($produkt['Name']); ?></h3>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
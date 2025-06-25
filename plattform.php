<?php
// Verbindung zur Datenbank
require_once 'db_connect.php';

// Plattform und Genre aus der URL holen
$plattform = isset($_GET['plattform']) ? $_GET['plattform'] : '';
$genre = isset($_GET['genre']) ? $_GET['genre'] : '';

// Sicherheit gegen SQL-Injections
$plattform = $conn->real_escape_string($plattform);
$genre = $conn->real_escape_string($genre);

// SQL-Query
$sql = "SELECT * FROM Produkte WHERE Plattform LIKE '%$plattform%' AND Genre LIKE '%$genre%'";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Spieleplattform</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Styles.css" type="text/css" />
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('http://localhost/FinalPixel/pictures/Market.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            background-attachment: fixed;
            margin: 0;
            padding: 0;
            color: #333;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        main {
            padding: 20px;
            flex: 1;
            display: flex;
            justify-content: center;
        }
        .filter-container {
            display: flex;
            justify-content: space-between;
            padding: 20px;
            background: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            margin-top: 20px;
            animation: fadeIn 1s ease-in-out;
            width: 80%;
        }
        .filter-game-foreshow {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            flex: 1;
        }
        .filter-game-window {
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid #ccc;
            border-radius: 10px;
            width: 200px;
            height: 400px;
            text-align: center;
            padding: 10px;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .filter-game-window:hover {
            transform: scale(1.05);
            box-shadow: 0 0 15px rgba(0,0,0,0.2);
        }
        .filter-game-window img {
            width: 100%;
            height: auto;
            border-radius: 10px;
        }
        .filter-game-window h3 {
            margin: 10px 0;
            font-size: 18px;
            color: #333;
        }
        .filter-game-window a {
            text-decoration: none;
            color: #007BFF;
            font-weight: bold;
        }
        .filter-game-window a:hover {
            text-decoration: underline;
        }
        .filters {
            background: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            max-height: 400px;
            overflow-y: auto;
            margin-left: 20px;
        }
        .filters h3 {
            margin-top: 0;
        }
        .filters label {
            display: block;
            margin: 10px 0 5px;
        }
        .filters select,
        .filters button {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .filters button {
            background-color: #8b4513;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .filters button:hover {
            background-color: #a0522d;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
    </style>
</head>
<body>
    <header>
        <?php include 'header.php'; ?>
    </header>
    <main>
        <div class="filter-container">
            <div class="filter-game-foreshow">
                <h2>Ergebnisse: <?= htmlspecialchars($plattform ?: 'Alle Plattformen') ?></h2>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<div class='filter-game-window'>";
                        echo "<a href='produkt.php?artikelnummer=" . htmlspecialchars($row['Artikelnummer']) . "'>";
                        echo "<img src='" . htmlspecialchars($row['bild_url']) . "' alt='" . htmlspecialchars($row['Name']) . "'>";
                        echo "<h3>" . htmlspecialchars($row["Name"]) . "</h3>";
                        echo "<p>Preis: " . htmlspecialchars($row["Preis"]) . " €</p>";
                        echo "<p>Genre: " . htmlspecialchars($row["Genre"]) . "</p>";
                        echo "</a>";
                        echo "</div>";
                    }
                } else {
                    echo "<p>Keine Spiele für diese Auswahl gefunden.</p>";
                }
                $conn->close();
                ?>
            </div>
            <div class="filters">
                <h3>Filter</h3>
                <form method="GET" action="">
                    <label for="plattform">Plattform:</label>
                    <select name="plattform" id="plattform">
                        <option value="">Alle</option>
                        <option value="PC">PC</option>
                        <option value="PS">PlayStation</option>
                        <option value="Xbox">Xbox</option>
                        <option value="Switch">Nintendo Switch</option>
                    </select>
                    <label for="genre">Genre:</label>
                    <select name="genre" id="genre">
                        <option value="">Alle</option>
                        <option value="Action">Action</option>
                        <option value="Adventure">Adventure</option>
                        <option value="RPG">Rollenspiel</option>
                        <option value="Simulation">Simulation</option>
                        <option value="Sport">Sport</option>
                        <option value="Strategie">Strategie</option>
                        <option value="Shooter">Shooter</option>
                        <option value="Sandbox">Sandbox</option>
                        <option value="CS2_Cases">CS2 Cases</option>
                    </select>
                    <button type="submit">Filtern</button>
                </form>
            </div>
        </div>
    </main>
    <?php include 'footer.php'; ?>
</body>
</html>

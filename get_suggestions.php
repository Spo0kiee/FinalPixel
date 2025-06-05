<?php
require_once 'db_connect.php';

if (isset($_GET['query'])) {
    $query = trim($_GET['query']);
    $query = "%$query%";

    $stmt = $conn->prepare("SELECT Artikelnummer, Name, bild_url FROM produkte WHERE Name LIKE ? LIMIT 5");
    $stmt->bind_param("s", $query);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="suggestion-item">';
            echo '<a href="produkt.php?Artikelnummer=' . htmlspecialchars($row['Artikelnummer']) . '">';
            echo '<img src="' . htmlspecialchars($row['bild_url']) . '" alt="' . htmlspecialchars($row['Name']) . '" width="50" height="50">';
            echo '<span>' . htmlspecialchars($row['Name']) . '</span>';
            echo '</a>';
            echo '</div>';
        }
    } else {
        echo '<div class="suggestion-item">Kein Produkt gefunden.</div>';
    }
    $stmt->close();
}
?>
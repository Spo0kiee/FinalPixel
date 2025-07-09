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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = $_SESSION['userid']; 
    $profileDescription = trim($_POST['profile-description']);

    // Datei-Upload behandeln
    if (isset($_FILES['profile-pic']) && $_FILES['profile-pic']['error'] == UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['profile-pic']['tmp_name'];
        $fileName = $_FILES['profile-pic']['name'];
        $fileSize = $_FILES['profile-pic']['size'];
        $fileType = $_FILES['profile-pic']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // Dateinamen bereinigen
        $newFileName = md5(time() . $fileName) . '.' . $fileExtension;

        // Überprüfen, ob die Datei ein Bild ist
        $allowedfileExtensions = array('jpg', 'gif', 'png', 'jpeg');
        if (in_array($fileExtension, $allowedfileExtensions)) {
            // Verzeichnis, in das die hochgeladene Datei verschoben wird
            $uploadFileDir = 'uploaded_files/';
            $dest_path = $uploadFileDir . $newFileName;

            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                // Aktualisiere Profilbild in der Datenbank
                $stmt = $conn->prepare("UPDATE kunden SET profilbild = ?, beschreibung = ? WHERE Kundennummer = ?");
                $stmt->bind_param("ssi", $dest_path, $profileDescription, $userId);

                if ($stmt->execute()) {
                    echo "Profile updated successfully!";
                } else {
                    echo "Error updating profile: " . $stmt->error;
                }

                $stmt->close();
            } else {
                echo "There was an error moving the uploaded file.";
            }
        } else {
            echo "Upload failed. Allowed file types: " . implode(',', $allowedfileExtensions);
        }
    } else {
        // Aktualisiere die Beschreibung nur, wenn keine Datei hochgeladen wurde
        $stmt = $conn->prepare("UPDATE kunden SET beschreibung = ? WHERE Kundennummer = ?");
        $stmt->bind_param("si", $profileDescription, $userId);

        if ($stmt->execute()) {
            echo "Profile updated successfully!";
        } else {
            echo "Error updating profile: " . $stmt->error;
        }

        $stmt->close();
    }
}

$conn->close();
?>
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
    $userId = $_SESSION['userid']; // Assuming you have the user ID stored in the session
    $profileDescription = trim($_POST['profile-description']);

    // Handle file upload
    if (isset($_FILES['profile-pic']) && $_FILES['profile-pic']['error'] == UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['profile-pic']['tmp_name'];
        $fileName = $_FILES['profile-pic']['name'];
        $fileSize = $_FILES['profile-pic']['size'];
        $fileType = $_FILES['profile-pic']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // Sanitize file name
        $newFileName = md5(time() . $fileName) . '.' . $fileExtension;

        // Check if file is an image
        $allowedfileExtensions = array('jpg', 'gif', 'png', 'jpeg');
        if (in_array($fileExtension, $allowedfileExtensions)) {
            // Directory in which the uploaded file will be moved
            $uploadFileDir = 'uploaded_files/';
            $dest_path = $uploadFileDir . $newFileName;

            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                // Update profile picture in the database
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
        // Update description only if no file is uploaded
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
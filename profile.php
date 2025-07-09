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
// Angenommen, Sie haben die Benutzer-ID in der Sitzung gespeichert
$userId = $_SESSION['userid'];
// Benutzerdaten aus der Datenbank abrufen
$stmt = $conn->prepare("SELECT Name, Email, profilbild, beschreibung FROM kunden WHERE Kundennummer = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$stmt->bind_result($name, $email, $profilbild, $beschreibung);
$stmt->fetch();
$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <link rel="stylesheet" href="Styles.css" type="text/css" />
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600&family=EB+Garamond&display=swap" rel="stylesheet">
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
    }
</style>
<body>
<header>
    <?php include 'header.php'; ?>
</header>
<div class="profile-container">
    <!-- Profile Header -->
    <div class="profile-header">
        <img src="<?php echo htmlspecialchars($profilbild ? $profilbild : 'http://localhost/FinalPixel/pictures/Profile-icon.png'); ?>" alt="User Avatar" id="profile-pic">
        <div class="profile-info">
            <h2 id="profile-name"><?php echo htmlspecialchars($name); ?></h2>
            <p id="profile-email">Email: <?php echo htmlspecialchars($email); ?></p>
            <p id="profile-description">Beschreibung: <?php echo htmlspecialchars($beschreibung); ?></p>
        </div>
    </div>


    <!-- Profile Actions -->
    <div class="profile-actions">
        <button id="edit-profile-btn">Profil bearbeiten</button>
        <button id="change-password-btn">Passwort ändern</button>
    </div>


<!-- Order History -->
<div class="games-section">
    <h3>Ihre Spiele</h3>
        <div class="game-list">
            <div class="game-item">
                <img src="http://localhost/FinalPixel/pictures/KingdomCome.jpg" alt="Kingdom Come">
                <p>Kingdom Come</p>
            </div>
            <div class="game-item">
                <img src="http://localhost/FinalPixel/pictures/Avowed.jpg" alt="Avowed">
                <p>Avowed</p>
            </div>
            <div class="game-item">
                <img src="http://localhost/FinalPixel/pictures/SIDMEIERS.jpg" alt="Civilization VI">
                <p>Civilization VI</p>
            </div>
        </div>
    </div>
</div>

<!-- Edit Profile Modal -->
<div id="edit-profile-modal" class="modal">
    <div class="modal-content">
        <span class="close" id="close-edit-profile">&times;</span>
        <h2>Profil bearbeiten</h2>
        <form id="edit-profile-form" enctype="multipart/form-data">
            <label for="profile-pic-input">Profilbild:</label>
            <input type="file" id="profile-pic-input" name="profile-pic">
            <label for="profile-description-input">Beschreibung:</label>
            <textarea id="profile-description-input" name="profile-description"></textarea>
            <button type="submit">Änderungen speichern</button>
        </form>
    </div>
</div>

<!-- Change Password Modal -->
<div id="change-password-modal" class="modal">
    <div class="modal-content">
        <span class="close" id="close-change-password">&times;</span>
        <h2>Passwort ändern</h2>
        <form id="change-password-form" action="change_password.php" method="post">
            <label for="current-password">Aktuelles Passwort:</label>
            <input type="password" id="current-password" name="current-password" required>
            <label for="new-password">Neues Passwort:</label>
            <input type="password" id="new-password" name="new-password" required>
            <label for="confirm-password">Neues Passwort bestätigen:</label>
            <input type="password" id="confirm-password" name="confirm-password" required>
            <button type="submit">Passwort ändern</button>
        </form>
    </div>
</div>
<script>
    // Get the modals
    var editProfileModal = document.getElementById("edit-profile-modal");
    var changePasswordModal = document.getElementById("change-password-modal");

    // Get the buttons that open the modals
    var editProfileBtn = document.getElementById("edit-profile-btn");
    var changePasswordBtn = document.getElementById("change-password-btn");

    // Get the <span> elements that close the modals
    var closeEditProfile = document.getElementById("close-edit-profile");
    var closeChangePassword = document.getElementById("close-change-password");

    // When the user clicks the button, open the modal
    editProfileBtn.onclick = function() {
        editProfileModal.style.display = "block";
    }
    changePasswordBtn.onclick = function() {
        changePasswordModal.style.display = "block";
    }

    // When the user clicks on <span> (x), close the modal
    closeEditProfile.onclick = function() {
        editProfileModal.style.display = "none";
    }
    closeChangePassword.onclick = function() {
        changePasswordModal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == editProfileModal) {
            editProfileModal.style.display = "none";
        }
        if (event.target == changePasswordModal) {
            changePasswordModal.style.display = "none";
        }
    }

    // Handle form submissions
    document.getElementById("edit-profile-form").onsubmit = function(event) {
        event.preventDefault();
        var formData = new FormData(this);

        fetch('update_profile.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            console.log(data);
            if (data.includes("Profile updated successfully!")) {
                // Update the profile picture and description on the page
                var profilePic = document.getElementById("profile-pic-input").files[0];
                if (profilePic) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        document.getElementById("profile-pic").src = e.target.result;
                    }
                    reader.readAsDataURL(profilePic);
                }
                document.getElementById("profile-description").innerText = "Description: " + document.getElementById("profile-description-input").value;
                editProfileModal.style.display = "none";
            } else {
                alert("Error updating profile: " + data);
            }
        })
        .catch(error => console.error('Error:', error));
    }
</script>
<?php include 'footer.php'; ?>
</body>
</html>
<?php
session_start();
if (!isset($_SESSION['userid'])) {
    header("Location: login.php");
    exit();
}
?>
<h1>Welcome to FinalPixel! <?php echo htmlspecialchars($_SESSION['']); ?>!</h1>

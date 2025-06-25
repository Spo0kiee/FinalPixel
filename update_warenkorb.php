<?php
session_start();

if (!isset($_POST['action']) || !isset($_POST['artikelnummer'])) {
    die("Ungültige Anfrage.");
}

$action = $_POST['action'];
$artikelnummer = $_POST['artikelnummer'];

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

switch ($action) {
    case 'add':
        if (!isset($_SESSION['cart'][$artikelnummer])) {
            $_SESSION['cart'][$artikelnummer] = 1;
        } else {
            $_SESSION['cart'][$artikelnummer]++;
        }
        break;
    case 'remove':
        if (isset($_SESSION['cart'][$artikelnummer])) {
            $_SESSION['cart'][$artikelnummer]--;
            if ($_SESSION['cart'][$artikelnummer] <= 0) {
                unset($_SESSION['cart'][$artikelnummer]);
            }
        }
        break;
    case 'delete':
        if (isset($_SESSION['cart'][$artikelnummer])) {
            unset($_SESSION['cart'][$artikelnummer]);
        }
        break;
    default:
        die("Ungültige Aktion.");
}

header("Location: warenkorb.php");
exit();
?>
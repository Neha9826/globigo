<?php
session_start();

if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_name'])) {
    header("Location: login.php");
    exit();
}

// Now you can use $_SESSION['user_id'], $_SESSION['user_name'], $_SESSION['user_role']
?>

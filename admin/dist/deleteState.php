<?php
include('session.php');
require_once('config.php');

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

    $stmt = $conn->prepare("DELETE FROM states WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $conn->close();
}

header("Location: addState.php");
exit();
?>

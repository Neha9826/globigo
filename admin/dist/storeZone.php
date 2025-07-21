<?php
require_once('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $country_id = $_POST['country_id'];
    $zone_name = trim($_POST['zone_name']);

    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

    $stmt = $conn->prepare("INSERT INTO zones (name, country_id) VALUES (?, ?)");
    $stmt->bind_param("si", $zone_name, $country_id);

    if ($stmt->execute()) {
        header("Location: addZone.php?success=1");
    } else {
        echo "Error: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<?php
require_once('config.php');
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$id = $_POST['id'];
$name = trim($_POST['name']);
$zone_id = $_POST['zone_id'];

if ($id && $name && $zone_id) {
  $stmt = $conn->prepare("UPDATE states SET name = ?, zone_id = ? WHERE id = ?");
  $stmt->bind_param("sii", $name, $zone_id, $id);
  $stmt->execute();
  $stmt->close();
}

$conn->close();
header("Location: addState.php");
exit;

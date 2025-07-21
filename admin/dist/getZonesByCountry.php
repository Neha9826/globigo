<?php
require_once('config.php');
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$country_id = $_GET['country_id'] ?? 0;
$zones = [];

$sql = "SELECT id, name FROM zones WHERE country_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $country_id);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
  $zones[] = $row;
}

echo json_encode($zones);
?>

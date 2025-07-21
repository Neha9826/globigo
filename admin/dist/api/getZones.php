<?php
require_once('../config.php');
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$country_id = $_GET['country_id'];
$result = $conn->query("SELECT id, name FROM zones WHERE country_id = $country_id ORDER BY name ASC");
$zones = [];
while ($row = $result->fetch_assoc()) {
  $zones[] = $row;
}
echo json_encode($zones);
?>

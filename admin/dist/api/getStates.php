<?php
require_once('../config.php');
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$zone_id = $_GET['zone_id'];
$result = $conn->query("SELECT id, name FROM states WHERE zone_id = $zone_id ORDER BY name ASC");
$states = [];
while ($row = $result->fetch_assoc()) {
  $states[] = $row;
}
echo json_encode($states);
?>

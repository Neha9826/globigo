<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
  require_once('config.php');
  $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

  $zone_id = $_POST['zone_id'];
  $state_name = trim($_POST['state_name']);

  $stmt = $conn->prepare("INSERT INTO states (zone_id, name) VALUES (?, ?)");
  $stmt->bind_param("is", $zone_id, $state_name);
  $stmt->execute();

  header("Location: addState.php");
  exit();
}
?>

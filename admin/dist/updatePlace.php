<?php
require_once('config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'], $_POST['state_id'], $_POST['place_name'])) {
  $id = intval($_POST['id']);
  $state_id = intval($_POST['state_id']);
  $place_name = trim($_POST['place_name']);

  $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
  if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

  $stmt = $conn->prepare("UPDATE places SET state_id = ?, name = ? WHERE id = ?");
  $stmt->bind_param("isi", $state_id, $place_name, $id);
  $stmt->execute();
  $stmt->close();
  $conn->close();

  header("Location: addPlace.php");
  exit();
} else {
  echo "Invalid request.";
}

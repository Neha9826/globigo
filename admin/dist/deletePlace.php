<?php
require_once('config.php');

if (isset($_GET['id']) && !empty($_GET['id'])) {
  $id = intval($_GET['id']);
  $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
  if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

  $stmt = $conn->prepare("DELETE FROM places WHERE id = ?");
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $stmt->close();
  $conn->close();
}

header("Location: addPlace.php");
exit();

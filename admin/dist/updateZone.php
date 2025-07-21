<?php
include('config.php');

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = trim($_POST['name']);

    $stmt = $conn->prepare("UPDATE zones SET name = ? WHERE id = ?");
    $stmt->bind_param("si", $name, $id);

    if ($stmt->execute()) {
        header("Location: addZone.php?success=updated");
        exit();
    } else {
        echo "Error updating zone.";
    }
}
?>

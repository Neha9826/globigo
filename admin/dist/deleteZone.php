<?php
include('config.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conn->prepare("DELETE FROM zones WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: addZone.php?success=deleted");
        exit();
    } else {
        echo "Error deleting zone.";
    }
}
?>

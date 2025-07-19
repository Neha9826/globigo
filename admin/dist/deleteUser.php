<?php
require_once('config.php');

if (isset($_GET['id'])) {
    $userId = $_GET['id'];

    // Connect to DB
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get the image file path first to delete it from the server
    $imageSql = "SELECT image FROM users WHERE id = ?";
    $stmt = $conn->prepare($imageSql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->bind_result($imageFile);
    $stmt->fetch();
    $stmt->close();

    // Delete user record from DB
    $deleteSql = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($deleteSql);
    $stmt->bind_param("i", $userId);

    if ($stmt->execute()) {
        // Delete the image file if exists
        if (!empty($imageFile) && file_exists('uploads/' . $imageFile)) {
            unlink('uploads/' . $imageFile);
        }
        $stmt->close();
        $conn->close();
        header("Location: allUsers.php?msg=deleted");
        exit;
    } else {
        $stmt->close();
        $conn->close();
        header("Location: allUsers.php?msg=error");
        exit;
    }
} else {
    header("Location: allUsers.php");
    exit;
}
?>

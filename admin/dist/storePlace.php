<?php
require_once('config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $country_id = $_POST['country_id'];
    $zone_id = $_POST['zone_id'];
    $state_id = $_POST['state_id'];
    $place_name = trim($_POST['place_name']);

    if ($country_id && $zone_id && $state_id && $place_name) {
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        // Check for duplicate entry
        $check_sql = "SELECT * FROM places WHERE name = ? AND state_id = ?";
        $stmt = $conn->prepare($check_sql);
        $stmt->bind_param("si", $place_name, $state_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Redirect back with error
            header("Location: addPlace.php?error=Place already exists");
            exit();
        }

        // Insert new place
        $sql = "INSERT INTO places (name, state_id) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $place_name, $state_id);

        if ($stmt->execute()) {
            header("Location: addPlace.php?success=Place added successfully");
        } else {
            header("Location: addPlace.php?error=Something went wrong");
        }

        $stmt->close();
        $conn->close();
    } else {
        header("Location: addPlace.php?error=All fields are required");
    }
} else {
    header("Location: addPlace.php");
}
?>

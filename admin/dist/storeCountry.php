<?php
require_once('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);

    if (!empty($name)) {
        // Create DB connection
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prevent duplicate country
        $checkQuery = "SELECT * FROM countries WHERE name = ?";
        $stmtCheck = $conn->prepare($checkQuery);
        $stmtCheck->bind_param("s", $name);
        $stmtCheck->execute();
        $result = $stmtCheck->get_result();

        if ($result->num_rows > 0) {
            $conn->close();
            echo "<script>alert('Country already exists!'); window.location.href='addCountry.php';</script>";
            exit;
        }

        // Insert new country
        $stmt = $conn->prepare("INSERT INTO countries (name) VALUES (?)");
        $stmt->bind_param("s", $name);

        if ($stmt->execute()) {
            $conn->close();
            echo "<script>alert('Country added successfully!'); window.location.href='addCountry.php';</script>";
            exit;
        } else {
            $conn->close();
            echo "<script>alert('Error while inserting data.'); window.location.href='addCountry.php';</script>";
            exit;
        }
    } else {
        echo "<script>alert('Country name is required.'); window.location.href='addCountry.php';</script>";
        exit;
    }
} else {
    header("Location: allCountries.php");
    exit;
}

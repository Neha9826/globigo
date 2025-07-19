<?php
include('session.php');
include('config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id         = $_POST['id'];
    $name       = $_POST['name'];
    $email      = $_POST['email'];
    $phone      = $_POST['phone'];
    $password   = $_POST['password']; // optional
    $aadhaar    = $_POST['aadhaar'];
    $pan        = $_POST['pan'];
    $address    = $_POST['address'];
    $role       = $_POST['role'];
    $doj        = $_POST['doj'];
    $designation= $_POST['designation'];
    $salary     = $_POST['salary'];

    // Image upload
    $image = '';
    if (!empty($_FILES['image']['name'])) {
        $targetDir = "uploads/";
        $image = basename($_FILES["image"]["name"]);
        $targetFilePath = $targetDir . $image;
        move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath);
    }

    // Fetch current user to get existing image if needed
    $oldQuery = "SELECT image FROM users WHERE id = '$id'";
    $oldResult = $conn->query($oldQuery);
    $oldData = $oldResult->fetch_assoc();
    if (empty($image)) {
        $image = $oldData['image']; // retain old image
    }

    // Update user record
    $updateQuery = "UPDATE users SET 
        name = '$name',
        email = '$email',
        phone = '$phone',
        aadhaar = '$aadhaar',
        pan = '$pan',
        address = '$address',
        role = '$role',
        doj = '$doj',
        image = '$image',
        designation = '$designation'
        WHERE id = '$id'";

    if (!empty($password)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $updateQuery = "UPDATE users SET 
            name = '$name',
            email = '$email',
            phone = '$phone',
            aadhaar = '$aadhaar',
            pan = '$pan',
            address = '$address',
            role = '$role',
            doj = '$doj',
            image = '$image',
            designation = '$designation',
            password = '$hashedPassword'
            WHERE id = '$id'";
    }

    if ($conn->query($updateQuery)) {
        // Insert into user_salaries only if a new salary is provided
        if (!empty($salary) && !empty($doj)) {
            $salaryInsert = "INSERT INTO user_salaries (user_id, salary, effective_from)
                             VALUES ('$id', '$salary', '$doj')";
            $conn->query($salaryInsert);
        }

        $_SESSION['success'] = "User updated successfully.";
    } else {
        $_SESSION['error'] = "Error updating user: " . $conn->error;
    }

    header("Location: viewUser.php?id=" . $id);
    exit;
} else {
    header("Location: allUsers.php");
    exit;
}
?>

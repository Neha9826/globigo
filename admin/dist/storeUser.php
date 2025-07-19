<?php
require_once('config.php');

if (isset($_POST['submit'])) {
    $name         = $_POST['name'];
    $email        = $_POST['email'];
    $phone        = $_POST['phone'];
    $password     = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $aadhaar      = $_POST['aadhaar'];
    $pan          = $_POST['pan'];
    $address      = $_POST['address'];
    $role         = $_POST['role'];
    $salary       = $_POST['salary'];
    $designation  = $_POST['designation'];
    $doj          = $_POST['doj'];
    $created_at   = date('Y-m-d H:i:s');

    // Handle image upload
    $image = '';
    if (!empty($_FILES['image']['name'])) {
        $imageName = time() . '_' . $_FILES['image']['name'];
        $imageTmp = $_FILES['image']['tmp_name'];
        move_uploaded_file($imageTmp, 'uploads/users/' . $imageName);
        $image = $imageName;
    }

    // Insert into users table (excluding salary)
    $stmt = $conn->prepare("INSERT INTO users (name, email, phone, password, aadhaar, pan, address, role, designation, doj, image, created_at)
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssssss", $name, $email, $phone, $password, $aadhaar, $pan, $address, $role, $designation, $doj, $image, $created_at);

    if ($stmt->execute()) {
        $user_id = $conn->insert_id;

        // Save initial salary in user_salaries
        if (!empty($salary) && !empty($doj)) {
            $salaryInsert = "INSERT INTO user_salaries (user_id, salary, effective_from)
                             VALUES ('$user_id', '$salary', '$doj')";
            $conn->query($salaryInsert);
        }

        $_SESSION['success'] = "User created successfully!";
        header("Location: allUsers.php");
        exit();
    } else {
        $_SESSION['error'] = "Failed to create user!";
        header("Location: createUser.php");
        exit();
    }
} else {
    header("Location: createUser.php");
    exit();
}
?>

<?php
require_once 'session.php';
require_once 'config.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
  die("Invalid user ID.");
}

$id = (int) $_GET['id'];

// Fetch user info
$userSql = "SELECT * FROM users WHERE id = $id";
$userResult = $conn->query($userSql);
if ($userResult->num_rows == 0) {
  die("User not found.");
}
$user = $userResult->fetch_assoc();

// Fetch latest salary
$salarySql = "SELECT salary FROM user_salaries WHERE user_id = $id ORDER BY effective_from DESC LIMIT 1";
$salaryResult = $conn->query($salarySql);
$latestSalary = $salaryResult->num_rows > 0 ? $salaryResult->fetch_assoc()['salary'] : 0;

// Image path
$imagePath = !empty($user['image']) ? "uploads/users/" . $user['image'] : "assets/img/default-avatar.png";

// Date formatting
$createdAt = date("d M Y, h:i A", strtotime($user['created_at']));
$doj = !empty($user['doj']) ? date("d M Y", strtotime($user['doj'])) : '-';
?>
<!doctype html>
<html lang="en">
<?php include 'includes/header.php'; ?>
<body class="layout-fixed sidebar-expand-lg sidebar-open bg-body-tertiary">

<!-- Content Wrapper. Contains page content -->
<div class="app-wrapper">
    <?php include 'includes/navbar.php'; ?>
    <?php include 'includes/sidebar.php'; ?>
    <div class="container mt-4">
        <div class="card shadow">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h1>User Profile</h1>
            </div>
  

        <!-- Main content -->
            <div class="card-body box-profile text-center">
                <img class="profile-user-img img-fluid img-circle mb-3" src="<?= $imagePath ?>" alt="User profile picture" style="width: 120px; height: 120px; object-fit: cover;">
                <h3 class="profile-username text-center"><?= $user['name'] ?></h3>
                <p class="text-muted text-center"><?= $user['designation'] ?: 'No Designation' ?></p>

                <table class="table table-bordered mt-4 text-left w-75 mx-auto">
                    <tr>
                    <th>Email</th>
                    <td><?= $user['email'] ?></td>
                    </tr>
                    <tr>
                    <th>Phone</th>
                    <td><?= $user['phone'] ?></td>
                    </tr>
                    <tr>
                    <th>Role</th>
                    <td><?= $user['role'] ?></td>
                    </tr>
                    <tr>
                    <th>Designation</th>
                    <td><?= $user['designation'] ?: '-' ?></td>
                    </tr>
                    <tr>
                    <th>Date of Joining</th>
                    <td><?= $doj ?></td>
                    </tr>
                    <tr>
                    <th>Latest Salary</th>
                    <td>₹<?= number_format($latestSalary) ?></td>
                    </tr>
                    <tr>
                    <th>Aadhaar</th>
                    <td><?= $user['aadhaar'] ?></td>
                    </tr>
                    <tr>
                    <th>PAN</th>
                    <td><?= $user['pan'] ?></td>
                    </tr>
                    <tr>
                    <th>Address</th>
                    <td><?= $user['address'] ?></td>
                    </tr>
                    <tr>
                    <th>Created At</th>
                    <td><?= $createdAt ?></td>
                    </tr>
                </table>

                <div class="mt-4">
                    <a href="allUsers.php" class="btn btn-primary mr-2">Back to All Users</a>
                    <a href="editUser.php?id=<?= $user['id'] ?>" class="btn btn-info mr-2">Edit</a>
                    <a href="deleteUser.php?id=<?= $user['id'] ?>" onclick="return confirm('Are you sure to delete this user?')" class="btn btn-danger">Delete</a>
                </div>
            </div>
    </div>

<?php include('includes/footer.php'); ?>
<?php include('includes/js_scripts.php'); ?>

</body>
</html>
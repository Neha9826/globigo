<?php
include('session.php');
include('config.php');

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: allUsers.php");
    exit;
}

$user_id = $_GET['id'];

// Fetch user data
$query = "SELECT u.*, 
          (SELECT salary FROM user_salaries 
           WHERE user_id = u.id 
           ORDER BY effective_from DESC LIMIT 1) AS salary 
          FROM users u 
          WHERE u.id = $user_id";
$result = $conn->query($query);
if (!$result || $result->num_rows == 0) {
    echo "User not found.";
    exit;
}
$user = $result->fetch_assoc();
?>

<!doctype html>
<html lang="en">
<?php include('includes/header.php'); ?>

<body class="layout-fixed sidebar-expand-lg sidebar-open bg-body-tertiary">
  <div class="app-wrapper">
    <?php include('includes/navbar.php'); ?>
    <?php include('includes/sidebar.php'); ?>

    <div class="container mt-4">
      <div class="card shadow">
        <div class="card-header bg-warning text-white">
          <h4 class="mb-0">Edit User</h4>
        </div>
        <div class="card-body">
          <form action="updateUser.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $user['id'] ?>">

            <div class="row mb-3">
              <div class="col-md-6">
                <label class="form-label">Full Name</label>
                <input type="text" name="name" class="form-control" value="<?= $user['name'] ?>" required>
              </div>
              <div class="col-md-6">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="<?= $user['email'] ?>" required>
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-md-6">
                <label class="form-label">Phone</label>
                <input type="text" name="phone" class="form-control" value="<?= $user['phone'] ?>">
              </div>
              <div class="col-md-6">
                <label class="form-label">Password (leave blank to keep unchanged)</label>
                <input type="password" name="password" class="form-control">
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-md-6">
                <label class="form-label">Aadhaar Number</label>
                <input type="text" name="aadhaar" class="form-control" value="<?= $user['aadhaar'] ?>">
              </div>
              <div class="col-md-6">
                <label class="form-label">PAN Number</label>
                <input type="text" name="pan" class="form-control" value="<?= $user['pan'] ?>">
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-md-6">
                <label class="form-label">Address</label>
                <textarea name="address" class="form-control" rows="3"><?= $user['address'] ?></textarea>
              </div>
              <div class="col-md-6">
                <label class="form-label">Date of Joining</label>
                <input type="date" name="doj" class="form-control" value="<?= $user['doj'] ?>">
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-md-6">
                <label class="form-label">Role</label>
                <select name="role" class="form-select">
                  <option value="employee" <?= $user['role'] == 'employee' ? 'selected' : '' ?>>Employee</option>
                  <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                </select>
              </div>
              <div class="col-md-6">
                <label class="form-label">Upload Profile Image</label>
                <input type="file" name="image" class="form-control">
                <?php if ($user['image']) : ?>
                  <img src="uploads/<?= $user['image'] ?>" width="80" class="mt-2">
                <?php endif; ?>
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-md-6">
                <label class="form-label">Designation</label>
                <input type="text" name="designation" class="form-control" value="<?= $user['designation'] ?>">
              </div>
              <div class="col-md-6">
                <label class="form-label">Salary (₹)</label>
                <input type="number" step="0.01" name="salary" class="form-control" value="<?= $user['salary'] ?>">
              </div>
            </div>

            <div class="mt-4">
              <button type="submit" name="submit" class="btn btn-primary">Update User</button>
              <a href="viewUser.php?id=<?= $user['id'] ?>" class="btn btn-info mr-2">Back to view user</a>
            </div>
          </form>
        </div>
      </div>
    </div>

    <?php include('includes/footer.php'); ?>
    <?php include('includes/js_scripts.php'); ?>
  </div>
</body>
</html>

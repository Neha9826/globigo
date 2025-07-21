<?php
include('session.php');
include('config.php');

if (!isset($_GET['id'])) {
    header("Location: allCountries.php");
    exit();
}

$id = $_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM countries WHERE id = $id");
$country = mysqli_fetch_assoc($result);
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
      <h4 class="mb-0">Edit Country</h4>
    </div>
    <div class="card-body">
      <form action="updateCountry.php" method="POST">
        <input type="hidden" name="id" value="<?= $country['id']; ?>">
        <div class="mb-3">
          <label for="name" class="form-label">Country Name</label>
          <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($country['name']); ?>" required>
        </div>
        <div class="d-grid">
          <button type="submit" name="update" class="btn btn-success">Update Country</button>
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

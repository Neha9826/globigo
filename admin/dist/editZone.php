<?php
include('session.php');
include('includes/header.php');
include('config.php');

if (!isset($_GET['id'])) {
    header("Location: addZone.php");
    exit();
}

$id = $_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM zones WHERE id = $id");
$zone = mysqli_fetch_assoc($result);
?>

<body class="layout-fixed sidebar-expand-lg sidebar-open bg-body-tertiary">
<div class="app-wrapper">
<?php include('includes/navbar.php'); ?>
<?php include('includes/sidebar.php'); ?>

<div class="container mt-4">
  <div class="card shadow">
    <div class="card-header bg-warning text-white">
      <h4 class="mb-0">Edit Zone</h4>
    </div>
    <div class="card-body">
      <form action="updateZone.php" method="POST">
        <input type="hidden" name="id" value="<?= $zone['id']; ?>">
        <div class="mb-3">
          <label for="name" class="form-label">Zone Name</label>
          <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($zone['name']); ?>" required>
        </div>
        <div class="d-grid">
          <button type="submit" name="update" class="btn btn-success">Update Zone</button>
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

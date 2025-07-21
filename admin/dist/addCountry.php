<?php include('session.php'); ?>
<!doctype html>
<html lang="en">
<?php include('includes/header.php'); ?>

<body class="layout-fixed sidebar-expand-lg sidebar-open bg-body-tertiary">
  <div class="app-wrapper">
    <?php include('includes/navbar.php'); ?>
    <?php include('includes/sidebar.php'); ?>

    <!-- Main content -->
    <div class="container mt-4">
      <div class="card shadow">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
          <h4 class="mb-0">Add New Country</h4>
        </div>
        <div class="card-body">
          <!-- Add Country Form -->
          <form action="storeCountry.php" method="POST">
            <div class="mb-3">
              <label for="name" class="form-label">Country Name</label>
              <input type="text" name="name" id="name" class="form-control" placeholder="Enter country name" required>
            </div>
            <div class="d-grid">
              <button type="submit" name="submit" class="btn btn-success">Add Country</button>
            </div>
          </form>
        </div>
      </div>

      <!-- Countries Table -->
      <div class="card shadow mt-4">
        <div class="card-header bg-secondary text-white">
          <h4 class="mb-0">All Countries</h4>
        </div>
        <div class="card-body">
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>Sl No</th>
                <th>Country Name</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php
              require_once('config.php');
              $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
              if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
              }

              $sql = "SELECT * FROM countries ORDER BY id DESC";
              $result = $conn->query($sql);
              $sl = 1;

              if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                  echo "<tr>
                          <td>{$sl}</td>
                          <td>{$row['name']}</td>
                          <td>
                            <a href='editCountry.php?id={$row['id']}' class='btn btn-sm btn-primary'>Edit</a>
                            <a href='deleteCountry.php?id={$row['id']}' class='btn btn-sm btn-danger' onclick=\"return confirm('Are you sure you want to delete this country?')\">Delete</a>
                          </td>
                        </tr>";
                  $sl++;
                }
              } else {
                echo "<tr><td colspan='3' class='text-center'>No countries found.</td></tr>";
              }

              $conn->close();
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <!-- End main content -->

    <?php include('includes/footer.php'); ?>
    <?php include('includes/js_scripts.php'); ?>
  </div>
</body>
</html>

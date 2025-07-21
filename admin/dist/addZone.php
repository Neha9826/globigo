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
          <h4 class="mb-0">Add New Zone</h4>
        </div>
        <div class="card-body">
          <!-- Add Zone Form -->
          <form action="storeZone.php" method="POST">
            <div class="mb-3">
              <label for="country_id" class="form-label">Select Country</label>
              <select name="country_id" id="country_id" class="form-select" required>
                <option value="" disabled selected>-- Select Country --</option>
                <?php
                require_once('config.php');
                $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                $countries = $conn->query("SELECT * FROM countries ORDER BY name ASC");
                while ($row = $countries->fetch_assoc()) {
                  echo "<option value='{$row['id']}'>{$row['name']}</option>";
                }
                ?>
              </select>
            </div>
            <div class="mb-3">
              <label for="zone_name" class="form-label">Zone Name</label>
              <input type="text" name="zone_name" id="zone_name" class="form-control" placeholder="Enter zone name" required>
            </div>
            <div class="d-grid">
              <button type="submit" name="submit" class="btn btn-success">Add Zone</button>
            </div>
          </form>
        </div>
      </div>

      <!-- Zones Table -->
      <div class="card shadow mt-4">
        <div class="card-header bg-secondary text-white">
          <h4 class="mb-0">All Zones</h4>
        </div>
        <div class="card-body">
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>Sl No</th>
                <th>Zone Name</th>
                <th>Country</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $sql = "SELECT zones.id, zones.name AS zone_name, countries.name AS country_name 
                      FROM zones 
                      JOIN countries ON zones.country_id = countries.id 
                      ORDER BY zones.id DESC";
              $result = $conn->query($sql);
              $sl = 1;

              if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                  echo "<tr>
                          <td>{$sl}</td>
                          <td>{$row['zone_name']}</td>
                          <td>{$row['country_name']}</td>
                          <td>
                            <a href='editZone.php?id={$row['id']}' class='btn btn-sm btn-primary'>Edit</a>
                            <a href='deleteZone.php?id={$row['id']}' class='btn btn-sm btn-danger' onclick=\"return confirm('Are you sure you want to delete this zone?')\">Delete</a>
                          </td>
                        </tr>";
                  $sl++;
                }
              } else {
                echo "<tr><td colspan='4' class='text-center'>No zones found.</td></tr>";
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

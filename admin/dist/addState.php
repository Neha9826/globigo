<?php include('session.php'); ?>
<!doctype html>
<html lang="en">
<?php include('includes/header.php'); ?>

<body class="layout-fixed sidebar-expand-lg sidebar-open bg-body-tertiary">
<div class="app-wrapper">
  <?php include('includes/navbar.php'); ?>
  <?php include('includes/sidebar.php'); ?>

  <div class="container mt-4">
    <div class="card shadow">
      <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Add New State</h4>
      </div>
      <div class="card-body">
        <form action="storeState.php" method="POST">
          <div class="mb-3">
            <label for="country" class="form-label">Select Country</label>
            <select name="country_id" id="country_id" class="form-select" required>
              <option value="">-- Select Country --</option>
              <?php
              require_once('config.php');
              $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
              $country_sql = "SELECT * FROM countries ORDER BY name ASC";
              $country_result = $conn->query($country_sql);
              while ($row = $country_result->fetch_assoc()) {
                echo "<option value='{$row['id']}'>{$row['name']}</option>";
              }
              ?>
            </select>
          </div>

          <div class="mb-3">
            <label for="zone_id" class="form-label">Select Zone</label>
            <select name="zone_id" id="zone_id" class="form-select" required>
              <option value="">-- Select Zone --</option>
              <!-- Options will be populated using JS -->
            </select>
          </div>

          <div class="mb-3">
            <label for="state_name" class="form-label">State Name</label>
            <input type="text" name="state_name" id="state_name" class="form-control" placeholder="Enter state name" required>
          </div>

          <div class="d-grid">
            <button type="submit" name="submit" class="btn btn-success">Add State</button>
          </div>
        </form>
      </div>
    </div>

    <div class="card shadow mt-4">
      <div class="card-header bg-secondary text-white">
        <h4 class="mb-0">All States</h4>
      </div>
      <div class="card-body">
        <table class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>Sl No</th>
              <th>State Name</th>
              <th>Zone</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
          <?php
          $sql = "SELECT states.id, states.name AS state_name, zones.name AS zone_name 
                  FROM states 
                  JOIN zones ON states.zone_id = zones.id 
                  ORDER BY states.id DESC";
          $result = $conn->query($sql);
          $sl = 1;
          if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              echo "<tr>
                      <td>{$sl}</td>
                      <td>{$row['state_name']}</td>
                      <td>{$row['zone_name']}</td>
                      <td>
                        <a href='editState.php?id={$row['id']}' class='btn btn-sm btn-primary'>Edit</a>
                        <a href='deleteState.php?id={$row['id']}' class='btn btn-sm btn-danger' onclick=\"return confirm('Are you sure you want to delete this state?')\">Delete</a>
                      </td>
                    </tr>";
              $sl++;
            }
          } else {
            echo "<tr><td colspan='4' class='text-center'>No states found.</td></tr>";
          }
          $conn->close();
          ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <?php include('includes/footer.php'); ?>
  <?php include('includes/js_scripts.php'); ?>
  
  <script>
    document.getElementById('country_id').addEventListener('change', function () {
      const countryId = this.value;
      const zoneSelect = document.getElementById('zone_id');
      zoneSelect.innerHTML = '<option value="">Loading...</option>';

      fetch('getZonesByCountry.php?country_id=' + countryId)
        .then(response => response.json())
        .then(data => {
          let options = '<option value="">-- Select Zone --</option>';
          data.forEach(zone => {
            options += `<option value="${zone.id}">${zone.name}</option>`;
          });
          zoneSelect.innerHTML = options;
        })
        .catch(error => {
          zoneSelect.innerHTML = '<option value="">Error loading zones</option>';
        });
    });
  </script>
</div>
</body>
</html>

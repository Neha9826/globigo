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
          <h4 class="mb-0">Add New Place</h4>
        </div>
        <div class="card-body">
          <form action="storePlace.php" method="POST">
            <div class="mb-3">
              <label for="country_id" class="form-label">Select Country</label>
              <select class="form-select" name="country_id" id="country_id" required>
                <option value="">-- Select Country --</option>
                <?php
                require_once('config.php');
                $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                $result = $conn->query("SELECT * FROM countries ORDER BY name ASC");
                while ($row = $result->fetch_assoc()) {
                  echo "<option value='{$row['id']}'>{$row['name']}</option>";
                }
                ?>
              </select>
            </div>

            <div class="mb-3">
              <label for="zone_id" class="form-label">Select Zone</label>
              <select class="form-select" name="zone_id" id="zone_id" required>
                <option value="">-- Select Zone --</option>
              </select>
            </div>

            <div class="mb-3">
              <label for="state_id" class="form-label">Select State</label>
              <select class="form-select" name="state_id" id="state_id" required>
                <option value="">-- Select State --</option>
              </select>
            </div>

            <div class="mb-3">
              <label for="place_name" class="form-label">Place Name</label>
              <input type="text" name="place_name" id="place_name" class="form-control" placeholder="Enter place name" required>
            </div>

            <div class="d-grid">
              <button type="submit" name="submit" class="btn btn-success">Add Place</button>
            </div>
          </form>
        </div>
      </div>
      <!-- Places Table -->
      <div class="card shadow mt-4">
        <div class="card-header bg-secondary text-white">
          <h4 class="mb-0">All Places</h4>
        </div>
        <div class="card-body">
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>Sl No</th>
                <th>Place Name</th>
                <th>State</th>
                <th>Zone</th>
                <th>Country</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $placeSql = "SELECT places.id, places.name AS place_name, states.name AS state_name, 
                                  zones.name AS zone_name, countries.name AS country_name
                           FROM places 
                           JOIN states ON places.state_id = states.id 
                           JOIN zones ON states.zone_id = zones.id 
                           JOIN countries ON zones.country_id = countries.id
                           ORDER BY countries.name, zones.name, states.name, places.name";
              $placeResult = $conn->query($placeSql);
              $sl = 1;

              if ($placeResult->num_rows > 0) {
                while ($row = $placeResult->fetch_assoc()) {
                  echo "<tr>
                          <td>{$sl}</td>
                          <td>{$row['place_name']}</td>
                          <td>{$row['state_name']}</td>
                          <td>{$row['zone_name']}</td>
                          <td>{$row['country_name']}</td>
                          <td>
                            <a href='editPlace.php?id={$row['id']}' class='btn btn-sm btn-primary'>Edit</a>
                            <a href='deletePlace.php?id={$row['id']}' class='btn btn-sm btn-danger' onclick=\"return confirm('Are you sure you want to delete this place?')\">Delete</a>
                          </td>
                        </tr>";
                  $sl++;
                }
              } else {
                echo "<tr><td colspan='6' class='text-center'>No places found.</td></tr>";
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

    <script>
      // Load zones based on country
      document.getElementById('country_id').addEventListener('change', function () {
        const countryId = this.value;
        fetch('api/getZones.php?country_id=' + countryId)
          .then(res => res.json())
          .then(data => {
            let zoneSelect = document.getElementById('zone_id');
            zoneSelect.innerHTML = '<option value="">-- Select Zone --</option>';
            data.forEach(zone => {
              zoneSelect.innerHTML += `<option value="${zone.id}">${zone.name}</option>`;
            });

            // Reset states
            document.getElementById('state_id').innerHTML = '<option value="">-- Select State --</option>';
          });
      });

      // Load states based on zone
      document.getElementById('zone_id').addEventListener('change', function () {
        const zoneId = this.value;
        fetch('api/getStates.php?zone_id=' + zoneId)
          .then(res => res.json())
          .then(data => {
            let stateSelect = document.getElementById('state_id');
            stateSelect.innerHTML = '<option value="">-- Select State --</option>';
            data.forEach(state => {
              stateSelect.innerHTML += `<option value="${state.id}">${state.name}</option>`;
            });
          });
      });
    </script>
  </div>
</body>
</html>

<?php
include('session.php');
require_once('config.php');

// Connect DB
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$state_id = $_GET['id'];
$state = null;
$zone_id = '';
$country_id = '';

if ($state_id) {
  $sql = "SELECT s.id, s.name AS state_name, z.id AS zone_id, c.id AS country_id
          FROM states s
          JOIN zones z ON s.zone_id = z.id
          JOIN countries c ON z.country_id = c.id
          WHERE s.id = $state_id";

  $result = $conn->query($sql);
  if ($result && $result->num_rows > 0) {
    $state = $result->fetch_assoc();
    $zone_id = $state['zone_id'];
    $country_id = $state['country_id'];
  } else {
    echo "State not found.";
    exit;
  }
}

// Fetch all countries
$country_query = $conn->query("SELECT * FROM countries ORDER BY name ASC");

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<?php include('includes/header.php'); ?>
<body class="layout-fixed sidebar-expand-lg sidebar-open bg-body-tertiary">
  <div class="app-wrapper">
    <?php include('includes/navbar.php'); ?>
    <?php include('includes/sidebar.php'); ?>

    <div class="container mt-4">
      <div class="card shadow">
        <div class="card-header bg-warning text-white">
          <h4 class="mb-0">Edit State</h4>
        </div>
        <div class="card-body">
          <form action="updateState.php" method="POST">
            <input type="hidden" name="id" value="<?= $state_id ?>">

            <div class="mb-3">
              <label for="country">Select Country</label>
              <select name="country_id" id="country" class="form-select" required>
                <option value="">-- Select Country --</option>
                <?php while ($country = $country_query->fetch_assoc()): ?>
                  <option value="<?= $country['id'] ?>" <?= ($country['id'] == $country_id) ? 'selected' : '' ?>>
                    <?= $country['name'] ?>
                  </option>
                <?php endwhile; ?>
              </select>
            </div>

            <div class="mb-3">
              <label for="zone">Select Zone</label>
              <select name="zone_id" id="zone" class="form-select" required>
                <option value="">-- Select Zone --</option>
                <!-- Options will be populated via JS -->
              </select>
            </div>

            <div class="mb-3">
              <label for="name">State Name</label>
              <input type="text" name="name" id="name" class="form-control"
                     value="<?= htmlspecialchars($state['state_name']) ?>" required>
            </div>

            <div class="d-grid">
              <button type="submit" name="submit" class="btn btn-primary">Update State</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <?php include('includes/footer.php'); ?>
    <?php include('includes/js_scripts.php'); ?>
  </div>

  <script>
    // Populate zones based on selected country
    function loadZones(countryId, selectedZoneId = '') {
      if (!countryId) return;

      fetch('getZonesByCountry.php?country_id=' + countryId)
        .then(response => response.json())
        .then(data => {
          const zoneSelect = document.getElementById('zone');
          zoneSelect.innerHTML = '<option value="">-- Select Zone --</option>';

          data.forEach(zone => {
            const option = document.createElement('option');
            option.value = zone.id;
            option.textContent = zone.name;
            if (zone.id == selectedZoneId) {
              option.selected = true;
            }
            zoneSelect.appendChild(option);
          });
        })
        .catch(error => {
          console.error('Error loading zones:', error);
        });
    }

    // On page load, load zones for selected country
    document.addEventListener('DOMContentLoaded', () => {
      const countrySelect = document.getElementById('country');
      const selectedCountryId = '<?= $country_id ?>';
      const selectedZoneId = '<?= $zone_id ?>';

      if (selectedCountryId) {
        loadZones(selectedCountryId, selectedZoneId);
      }

      countrySelect.addEventListener('change', function () {
        loadZones(this.value);
      });
    });
  </script>
</body>
</html>

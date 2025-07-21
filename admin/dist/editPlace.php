<?php
include('session.php');
require_once('config.php');

if (!isset($_GET['id']) || empty($_GET['id'])) {
  header('Location: addPlace.php');
  exit();
}

$placeId = $_GET['id'];
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

// Fetch current place info
$placeSql = "SELECT * FROM places WHERE id = ?";
$stmt = $conn->prepare($placeSql);
$stmt->bind_param("i", $placeId);
$stmt->execute();
$placeResult = $stmt->get_result();

if ($placeResult->num_rows !== 1) {
  header('Location: addPlace.php');
  exit();
}

$placeData = $placeResult->fetch_assoc();
$stmt->close();
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
        <div class="card-header bg-primary text-white">
          <h4>Edit Place</h4>
        </div>
        <div class="card-body">
          <form action="updatePlace.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $placeData['id']; ?>">

            <div class="mb-3">
              <label for="state_id" class="form-label">State</label>
              <select name="state_id" id="state_id" class="form-select" required>
                <option value="">Select State</option>
                <?php
                $stateSql = "SELECT states.id as state_id, states.name as state_name, zones.name as zone_name, countries.name as country_name 
                             FROM states 
                             JOIN zones ON states.zone_id = zones.id 
                             JOIN countries ON zones.country_id = countries.id 
                             ORDER BY countries.name, zones.name, states.name";
                $stateResult = $conn->query($stateSql);
                if ($stateResult->num_rows > 0) {
                  while ($row = $stateResult->fetch_assoc()) {
                    $selected = ($row['state_id'] == $placeData['state_id']) ? "selected" : "";
                    echo "<option value='{$row['state_id']}' $selected>{$row['country_name']} > {$row['zone_name']} > {$row['state_name']}</option>";
                  }
                }
                ?>
              </select>
            </div>

            <div class="mb-3">
              <label for="place_name" class="form-label">Place Name</label>
              <input type="text" name="place_name" id="place_name" class="form-control" value="<?php echo htmlspecialchars($placeData['name']); ?>" required>
            </div>

            <div class="d-grid">
              <button type="submit" class="btn btn-success">Update Place</button>
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

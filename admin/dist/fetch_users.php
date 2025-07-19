<?php
require_once 'config.php';

$limit = 10;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
$offset = ($page - 1) * $limit;

// Main query with latest salary fetched from user_salaries
$sql = "SELECT u.*, 
        (SELECT salary FROM user_salaries 
         WHERE user_id = u.id 
         ORDER BY effective_from DESC LIMIT 1) AS latest_salary 
        FROM users u 
        WHERE u.name LIKE '%$search%' OR u.email LIKE '%$search%' 
        ORDER BY u.id DESC 
        LIMIT $offset, $limit";

$result = $conn->query($sql);

// Count query
$countSql = "SELECT COUNT(*) AS total FROM users 
             WHERE name LIKE '%$search%' OR email LIKE '%$search%'";
$countResult = $conn->query($countSql);
$total = $countResult->fetch_assoc()['total'];
$totalPages = ceil($total / $limit);
$i = $offset + 1;

echo '<div class="table-responsive">';
echo '<table class="table table-bordered table-hover align-middle">';
echo '<thead class="table-dark">
  <tr>
    <th>#</th>
    <th>Photo</th>
    <th>Name</th>
    <th>Email</th>
    <th>Phone</th>
    <th>Role</th>
    <th>Designation</th>
    <th>DOJ</th>
    <th>Salary (₹)</th>
    <th>Actions</th>
  </tr>
</thead>';
echo '<tbody>';

while ($row = $result->fetch_assoc()) {
  $imagePath = !empty($row['image']) ? 'uploads/users/' . $row['image'] : 'assets/img/default-avatar.png';
  $salary = $row['latest_salary'] !== null ? '₹' . number_format($row['latest_salary'], 2) : '₹0.00';

  echo "<tr>
    <td>{$i}</td>
    <td><img src='{$imagePath}' width='50' height='50' class='rounded-circle'></td>
    <td>{$row['name']}</td>
    <td>{$row['email']}</td>
    <td>{$row['phone']}</td>
    <td><span class='badge bg-" . ($row['role'] == 'admin' ? 'success' : 'primary') . "'>{$row['role']}</span></td>
    <td>{$row['designation']}</td>
    <td>" . ($row['doj'] ? date("d M Y", strtotime($row['doj'])) : '-') . "</td>
    <td>{$salary}</td>
    <td>
      <a href='viewUser.php?id={$row['id']}' class='btn btn-sm btn-primary'>View</a>
    </td>
  </tr>";
  $i++;
}

echo '</tbody>';
echo '</table>';
echo '</div>';

// Pagination
echo '<nav><ul class="pagination justify-content-center">';
for ($i = 1; $i <= $totalPages; $i++) {
  echo "<li class='page-item'><a class='page-link' href='#' data-page='{$i}'>{$i}</a></li>";
}
echo '</ul></nav>';
?>

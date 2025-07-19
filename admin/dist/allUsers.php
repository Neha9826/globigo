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
                <h4 class="mb-0">All Users</h4>
                <input type="text" id="search" class="form-control w-25" placeholder="Search by name or email">
                <a href="createUser.php" class="btn btn-light btn-sm">+ Add User</a>
            </div>
            <div class="card-body">
                <div id="userTable">
                    <!-- Table will be loaded here via AJAX -->
                </div>
            </div>
      </div>
    </div>

    <?php include('includes/footer.php'); ?>
    <?php include('includes/js_scripts.php'); ?>
  </div>

  <script>
    function loadUsers(query = '', page = 1) {
      fetch(`fetch_users.php?search=${query}&page=${page}`)
        .then(response => response.text())
        .then(data => {
          document.getElementById('userTable').innerHTML = data;
        });
    }

    document.addEventListener('DOMContentLoaded', () => {
      loadUsers();

      const searchInput = document.getElementById('search');
      let timeout = null;
      searchInput.addEventListener('keyup', () => {
        clearTimeout(timeout);
        timeout = setTimeout(() => {
          const query = searchInput.value.trim();
          loadUsers(query);
        }, 300);
      });

      document.addEventListener('click', function(e) {
        if (e.target.classList.contains('page-link')) {
          e.preventDefault();
          const page = e.target.dataset.page;
          const query = document.getElementById('search').value.trim();
          loadUsers(query, page);
        }
      });
    });
  </script>
</body>
</html>

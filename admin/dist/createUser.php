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
        <div class="card-header bg-primary text-white">
          <h4 class="mb-0">Create New User</h4>
        </div>
        <div class="card-body">
          <form action="storeUser.php" method="POST" enctype="multipart/form-data">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="name" class="form-label">Full Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="text" name="phone" class="form-control">
                </div>
                <div class="col-md-6">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="aadhaar" class="form-label">Aadhaar Number</label>
                    <input type="text" name="aadhaar" class="form-control">
                </div>
                <div class="col-md-6">
                    <label for="pan" class="form-label">PAN Number</label>
                    <input type="text" name="pan" class="form-control">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="address" class="form-label">Address</label>
                    <textarea name="address" class="form-control" rows="3"></textarea>
                </div>
                <div class="col-md-6">
                    <label for="doj">Date of Joining</label>
                    <input type="date" class="form-control" id="doj" name="doj">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="role" class="form-label">Role</label>
                    <select name="role" class="form-select" required>
                    <option value="employee" selected>Employee</option>
                    <option value="admin">Admin</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="image" class="form-label">Upload Profile Image</label>
                    <input type="file" name="image" class="form-control">
                </div>
            </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="designation">Designation</label>
                        <input type="text" class="form-control" id="designation" name="designation" placeholder="Enter Designation">
                    </div>
                    <div class="col-md-6">
                        <label for="salary" class="form-label">Salary (₹)</label>
                        <input type="number" step="0.01" name="salary" class="form-control">
                    </div>
                </div>
            
            <div class="d-grid">
              <button type="submit" name="submit" class="btn btn-success">Create User</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- End main content -->
    <?php include('includes/footer.php'); ?>
    <?php include('includes/js_scripts.php'); ?>
  </div>
</body>
</html>

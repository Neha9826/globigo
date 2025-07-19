<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$imagePath = !empty($_SESSION['user_image']) 
    ? '../uploads/users/' . $_SESSION['user_image'] 
    : 'assets/img/user2-160x160.jpg';
?>

<!--begin::Header-->
<nav class="app-header navbar navbar-expand bg-body">
  <div class="container-fluid">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
          <i class="bi bi-list"></i>
        </a>
      </li>
      <li class="nav-item d-none d-md-block">
        <a href="dashboard.php" class="nav-link">Home</a>
      </li>
    </ul>

    <ul class="navbar-nav ms-auto">
      <li class="nav-item">
        <a class="nav-link" href="#" data-lte-toggle="fullscreen">
          <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i>
          <i data-lte-icon="minimize" class="bi bi-fullscreen-exit" style="display: none"></i>
        </a>
      </li>

      <li class="nav-item dropdown user-menu">
        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
          <img
            src="../uploads/users/<?php echo $_SESSION['user_image']; ?>"
            class="user-image rounded-circle shadow"
            alt="User Image"
          />
          <span class="d-none d-md-inline">
            <?php echo htmlspecialchars($_SESSION['user_name'] ?? ''); ?>
          </span>
        </a>
        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
          <li class="user-header text-bg-primary">
            <img
              src="../uploads/users/<?php echo $_SESSION['user_image']; ?>"
              class="rounded-circle shadow"
              alt="User Image"
            />
            <p>
              <?php echo htmlspecialchars($_SESSION['user_name'] ?? ''); ?>
              <small>Welcome</small>
            </p>
          </li>
          <li class="user-footer">
            <a href="#" class="btn btn-default btn-flat">Profile</a>
            <a href="logout.php" class="btn btn-default btn-flat float-end">Sign out</a>
          </li>
        </ul>
      </li>
    </ul>
  </div>
</nav>

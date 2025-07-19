<?php header("Location: dist/login.php"); exit(); ?>

<!doctype html>
<html lang="en">
<?php include('admin/dist/includes/header.php'); ?>

<!--begin::Body-->
  <body class="layout-fixed sidebar-expand-lg sidebar-open bg-body-tertiary">
    <!--begin::App Wrapper-->
    <div class="app-wrapper">
  <!-- Content navbar -->
    <?php include('admin/dist/includes/navbar.php'); ?>

  <!--begin::Sidebar-->
    <?php include('admin/dist/includes/sidebar.php'); ?>
  <!--end::Sidebar-->

  <!-- Main content -->
    <?php include('admin/dist/includes/main.php'); ?>
  

<?php include('admin/dist/includes/footer.php'); ?>
<?php include('admin/dist/includes/js_scripts.php'); ?>
</body>
  <!--end::Body-->
</html>

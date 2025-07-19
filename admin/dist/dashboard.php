<?php include('session.php'); ?>

<!doctype html>
<html lang="en">
<?php include('includes/header.php'); ?>

<!--begin::Body-->
  <body class="layout-fixed sidebar-expand-lg sidebar-open bg-body-tertiary">
    <!--begin::App Wrapper-->
    <div class="app-wrapper">
  <!-- Content navbar -->
    <?php include('includes/navbar.php'); ?>

  <!--begin::Sidebar-->
    <?php include('includes/sidebar.php'); ?>
  <!--end::Sidebar-->

  <!-- Main content -->
    <?php include('includes/main.php'); ?>
  

<?php include('includes/footer.php'); ?>
<?php include('includes/js_scripts.php'); ?>
</body>
  <!--end::Body-->
</html>

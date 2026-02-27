<?php
include "../db.php";

$message = "";

if (isset($_POST['save'])) {
  $service_name = $_POST['service_name'];
  $description  = $_POST['description'];
  $hourly_rate  = $_POST['hourly_rate'];
  $is_active    = $_POST['is_active'];

  if ($service_name == "" || $hourly_rate == "") {
    $message = "Service name and hourly rate are required!";
  } elseif (!is_numeric($hourly_rate) || $hourly_rate <= 0) {
    $message = "Hourly rate must be a number greater than 0.";
  } else {
    $sql = "INSERT INTO services (service_name, description, hourly_rate, is_active)
            VALUES ('$service_name', '$description', '$hourly_rate', '$is_active')";
    mysqli_query($conn, $sql);
    header("Location: services_list.php");
    exit;
  }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Add Service</title>
  <link rel="stylesheet" href="../style.css">
</head>
<body>
<div class="wrapper">
  <?php include "../nav.php"; ?>

  <div class="page-bar">
    <h2>Add Service</h2>
    <a href="services_list.php" class="btn btn-sm" style="background:#f0f2f5;color:#555;">← Back to Services</a>
  </div>

  <?php if ($message) { ?>
    <div class="alert alert-error"><?php echo $message; ?></div>
  <?php } ?>

  <form method="post">
    <label>Service Name <span style="color:#e74c3c;">*</span></label>
    <input type="text" name="service_name" placeholder="e.g. Deep Cleaning">

    <label>Description</label>
    <textarea name="description" placeholder="Optional details about this service..."></textarea>

    <label>Hourly Rate (₱) <span style="color:#e74c3c;">*</span></label>
    <input type="number" name="hourly_rate" step="0.01" placeholder="0.00">

    <label>Status</label>
    <select name="is_active">
      <option value="1">Active</option>
      <option value="0">Inactive</option>
    </select>

    <button type="submit" name="save">Save Service</button>
  </form>
</div>
</body>
</html>
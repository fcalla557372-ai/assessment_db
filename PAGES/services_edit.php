<?php
include "../db.php";
$id = $_GET['id'];

$get     = mysqli_query($conn, "SELECT * FROM services WHERE service_id = $id");
$service = mysqli_fetch_assoc($get);

if (isset($_POST['update'])) {
  $name   = $_POST['service_name'];
  $desc   = $_POST['description'];
  $rate   = $_POST['hourly_rate'];
  $active = $_POST['is_active'];

  mysqli_query($conn, "UPDATE services
    SET service_name='$name', description='$desc', hourly_rate='$rate', is_active='$active'
    WHERE service_id=$id");

  header("Location: services_list.php");
  exit;
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Edit Service</title>
  <link rel="stylesheet" href="../style.css">
</head>
<body>
<div class="wrapper">
  <?php include "../nav.php"; ?>

  <div class="page-bar">
    <h2>Edit Service</h2>
    <a href="services_list.php" class="btn btn-sm" style="background:#f0f2f5;color:#555;">← Back to Services</a>
  </div>

  <form method="post">
    <label>Service Name</label>
    <input type="text" name="service_name" value="<?php echo htmlspecialchars($service['service_name']); ?>">

    <label>Description</label>
    <textarea name="description"><?php echo htmlspecialchars($service['description']); ?></textarea>

    <label>Hourly Rate (₱)</label>
    <input type="number" name="hourly_rate" step="0.01" value="<?php echo $service['hourly_rate']; ?>">

    <label>Status</label>
    <select name="is_active">
      <option value="1" <?php if ($service['is_active'] == 1) echo "selected"; ?>>Active</option>
      <option value="0" <?php if ($service['is_active'] == 0) echo "selected"; ?>>Inactive</option>
    </select>

    <button type="submit" name="update">Update Service</button>
  </form>
</div>
</body>
</html>
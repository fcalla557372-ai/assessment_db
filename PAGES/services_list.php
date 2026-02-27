<?php
include "../db.php";

if (isset($_GET['delete_id'])) {
  $delete_id = $_GET['delete_id'];
  mysqli_query($conn, "UPDATE services SET is_active=0 WHERE service_id=$delete_id");
  header("Location: services_list.php");
  exit;
}

$result = mysqli_query($conn, "SELECT * FROM services ORDER BY service_id DESC");
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Services</title>
  <link rel="stylesheet" href="../style.css">
</head>
<body>
<div class="wrapper">
  <?php include "../nav.php"; ?>

  <div class="page-bar">
    <h2>Services</h2>
    <a href="services_add.php" class="btn btn-primary">+ Add Service</a>
  </div>

  <table>
    <thead>
      <tr>
        <th>#</th>
        <th>Name</th>
        <th>Hourly Rate</th>
        <th>Status</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
          <td><?php echo $row['service_id']; ?></td>
          <td><?php echo htmlspecialchars($row['service_name']); ?></td>
          <td>₱<?php echo number_format($row['hourly_rate'], 2); ?>/hr</td>
          <td>
            <?php if ($row['is_active'] == 1) { ?>
              <span class="badge badge-success">Active</span>
            <?php } else { ?>
              <span class="badge badge-secondary">Inactive</span>
            <?php } ?>
          </td>
          <td style="display:flex;gap:8px;align-items:center;">
            <a href="services_edit.php?id=<?php echo $row['service_id']; ?>" class="btn btn-sm btn-warning">Edit</a>
            <?php if ($row['is_active'] == 1) { ?>
              <a href="services_list.php?delete_id=<?php echo $row['service_id']; ?>"
                 class="btn btn-sm btn-danger"
                 onclick="return confirm('Deactivate this service?')">Deactivate</a>
            <?php } ?>
          </td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</div>
</body>
</html>
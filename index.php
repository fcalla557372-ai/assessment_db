<?php
include "db.php";
 
$clients = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS c FROM clients"))['c'];
$services = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS c FROM services"))['c'];
$bookings = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS c FROM bookings"))['c'];
 
$revRow = mysqli_fetch_assoc(mysqli_query($conn, "SELECT IFNULL(SUM(amount_paid),0) AS s FROM payments"));
$revenue = $revRow['s'];
?>
<!doctype html>
<html>
<head>
<link rel="stylesheet" href="style.css">
  <meta charset="utf-8">
  <title>Dashboard</title>
  
</head>
<body>
<div class="wrapper">
  <?php include "nav.php"; ?>

  <h2>Dashboard</h2>

  <div class="cards">
    <div class="card">
      <div class="card-label">Total Clients</div>
      <div class="card-value"><?php echo $clients; ?></div>
    </div>
    <div class="card">
      <div class="card-label">Total Services</div>
      <div class="card-value"><?php echo $services; ?></div>
    </div>
    <div class="card">
      <div class="card-label">Total Bookings</div>
      <div class="card-value"><?php echo $bookings; ?></div>
    </div>
    <div class="card">
      <div class="card-label">Total Revenue</div>
      <div class="card-value">₱<?php echo number_format($revenue, 2); ?></div>
    </div>
  </div>

  <div class="quick-links">
    <span>Quick Links:</span>
    <a href="/assessment_db/pages/clients_add.php" class="btn btn-primary">+ Add Client</a>
    <a href="/assessment_db/pages/bookings_create.php" class="btn btn-success">+ Create Booking</a>
  </div>
</div>
 
</body>
</html>

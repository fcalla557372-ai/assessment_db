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
  <meta charset="utf-8">
  <title>Dashboard</title>
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f0f2f5;
      color: #333;
      margin: 0;
      padding: 0;
    }

    .wrapper {
      max-width: 1200px;
      margin: 0 auto;
      padding: 30px;
    }

    h2 {
      font-size: 26px;
      margin-bottom: 24px;
      color: #2c3e50;
      border-left: 5px solid #3498db;
      padding-left: 12px;
    }

    .cards {
      display: flex;
      gap: 20px;
      flex-wrap: wrap;
      margin-bottom: 30px;
    }

    .card {
      background: #fff;
      border-radius: 10px;
      padding: 24px 30px;
      flex: 1;
      min-width: 180px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.08);
      border-top: 4px solid #3498db;
      transition: transform 0.2s;
    }

    .card:hover {
      transform: translateY(-3px);
    }

    .card:nth-child(2) { border-top-color: #2ecc71; }
    .card:nth-child(3) { border-top-color: #e67e22; }
    .card:nth-child(4) { border-top-color: #9b59b6; }

    .card-label {
      font-size: 13px;
      color: #888;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      margin-bottom: 8px;
    }

    .card-value {
      font-size: 32px;
      font-weight: 700;
      color: #2c3e50;
    }

    .quick-links {
      background: #fff;
      border-radius: 10px;
      padding: 20px 24px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.08);
      display: inline-flex;
      align-items: center;
      gap: 16px;
    }

    .quick-links span {
      font-size: 14px;
      color: #888;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    .btn {
      display: inline-block;
      padding: 10px 20px;
      border-radius: 6px;
      text-decoration: none;
      font-size: 14px;
      font-weight: 600;
      transition: background 0.2s;
    }

    .btn-primary {
      background: #3498db;
      color: #fff;
    }

    .btn-primary:hover {
      background: #2980b9;
    }

    .btn-success {
      background: #2ecc71;
      color: #fff;
    }

    .btn-success:hover {
      background: #27ae60;
    }

    /* Nav styles */
    .navbar {
      display: flex;
      justify-content: center;
      gap: 6px;
      flex-wrap: wrap;
      background: #2c3e50;
      padding: 14px 20px;
      border-radius: 10px;
      margin-bottom: 28px;
    }

    .navbar a {
      color: #cfd8dc;
      text-decoration: none;
      padding: 8px 16px;
      border-radius: 6px;
      font-size: 14px;
      font-weight: 500;
      transition: background 0.2s, color 0.2s;
    }

    .navbar a:hover {
      background: #3498db;
      color: #fff;
    }

    .navbar a.active {
      background: #3498db;
      color: #fff;
    }
  </style>
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
    <a href="/assessment_beginner/pages/clients_add.php" class="btn btn-primary">+ Add Client</a>
    <a href="/assessment_beginner/pages/bookings_create.php" class="btn btn-success">+ Create Booking</a>
  </div>
</div>
 
</body>
</html>
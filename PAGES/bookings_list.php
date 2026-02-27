<?php
include "../db.php";

$sql = "
SELECT b.*, c.full_name AS client_name, s.service_name
FROM bookings b
JOIN clients c ON b.client_id = c.client_id
JOIN services s ON b.service_id = s.service_id
ORDER BY b.booking_id DESC
";
$result = mysqli_query($conn, $sql);
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Bookings</title>
  <link rel="stylesheet" href="../style.css">
</head>
<body>
<div class="wrapper">
  <?php include "../nav.php"; ?>

  <div class="page-bar">
    <h2>Bookings</h2>
    <a href="bookings_create.php" class="btn btn-primary">+ Create Booking</a>
  </div>

  <table>
    <thead>
      <tr>
        <th>#</th>
        <th>Client</th>
        <th>Service</th>
        <th>Date</th>
        <th>Hours</th>
        <th>Total</th>
        <th>Status</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($b = mysqli_fetch_assoc($result)) { ?>
        <tr>
          <td><?php echo $b['booking_id']; ?></td>
          <td><?php echo htmlspecialchars($b['client_name']); ?></td>
          <td><?php echo htmlspecialchars($b['service_name']); ?></td>
          <td><?php echo $b['booking_date']; ?></td>
          <td><?php echo $b['hours']; ?> hr<?php echo $b['hours'] > 1 ? 's' : ''; ?></td>
          <td>₱<?php echo number_format($b['total_cost'], 2); ?></td>
          <td>
            <?php
              $status = $b['status'];
              $class  = $status === 'PAID' ? 'badge-success' : 'badge-warning';
              echo "<span class=\"badge $class\">$status</span>";
            ?>
          </td>
          <td>
            <?php if ($b['status'] !== 'PAID') { ?>
              <a href="payment_process.php?booking_id=<?php echo $b['booking_id']; ?>"
                 class="btn btn-sm btn-primary">Process Payment</a>
            <?php } else { ?>
              <span style="color:#aaa;font-size:13px;">Fully Paid</span>
            <?php } ?>
          </td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</div>
</body>
</html>
<?php
include "../db.php";

$sql = "
SELECT p.*, b.booking_date, c.full_name
FROM payments p
JOIN bookings b ON p.booking_id = b.booking_id
JOIN clients c ON b.client_id = c.client_id
ORDER BY p.payment_id DESC
";
$result = mysqli_query($conn, $sql);
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Payments</title>
  <link rel="stylesheet" href="../style.css">
</head>
<body>
<div class="wrapper">
  <?php include "../nav.php"; ?>

  <div class="page-bar">
    <h2>Payments</h2>
  </div>

  <table>
    <thead>
      <tr>
        <th>#</th>
        <th>Client</th>
        <th>Booking ID</th>
        <th>Amount</th>
        <th>Method</th>
        <th>Date</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($p = mysqli_fetch_assoc($result)) { ?>
        <tr>
          <td><?php echo $p['payment_id']; ?></td>
          <td><?php echo htmlspecialchars($p['full_name']); ?></td>
          <td>#<?php echo $p['booking_id']; ?></td>
          <td>₱<?php echo number_format($p['amount_paid'], 2); ?></td>
          <td>
            <?php
              $method = $p['method'];
              $class  = $method === 'CASH' ? 'badge-success' : ($method === 'GCASH' ? 'badge-info' : 'badge-warning');
              echo "<span class=\"badge $class\">$method</span>";
            ?>
          </td>
          <td><?php echo $p['payment_date']; ?></td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</div>
</body>
</html>
<?php
include "../db.php";

$booking_id = $_GET['booking_id'];

$booking = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM bookings WHERE booking_id=$booking_id"));

$paidRow   = mysqli_fetch_assoc(mysqli_query($conn, "SELECT IFNULL(SUM(amount_paid),0) AS paid FROM payments WHERE booking_id=$booking_id"));
$total_paid = $paidRow['paid'];

$balance = $booking['total_cost'] - $total_paid;
$message = "";
$message_type = "error";

if (isset($_POST['pay'])) {
  $amount = $_POST['amount_paid'];
  $method = $_POST['method'];

  if ($amount <= 0) {
    $message = "Invalid amount!";
  } elseif ($amount > $balance) {
    $message = "Amount exceeds the remaining balance!";
  } else {
    mysqli_query($conn, "INSERT INTO payments (booking_id, amount_paid, method)
      VALUES ($booking_id, $amount, '$method')");

    $paidRow2   = mysqli_fetch_assoc(mysqli_query($conn, "SELECT IFNULL(SUM(amount_paid),0) AS paid FROM payments WHERE booking_id=$booking_id"));
    $total_paid2 = $paidRow2['paid'];
    $new_balance = $booking['total_cost'] - $total_paid2;

    if ($new_balance <= 0.009) {
      mysqli_query($conn, "UPDATE bookings SET status='PAID' WHERE booking_id=$booking_id");
    }

    header("Location: bookings_list.php");
    exit;
  }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Process Payment</title>
  <link rel="stylesheet" href="../style.css">
</head>
<body>
<div class="wrapper">
  <?php include "../nav.php"; ?>

  <div class="page-bar">
    <h2>Process Payment &mdash; Booking #<?php echo $booking_id; ?></h2>
    <a href="bookings_list.php" class="btn btn-sm" style="background:#f0f2f5;color:#555;">← Back to Bookings</a>
  </div>

  <?php if ($message) { ?>
    <div class="alert alert-<?php echo $message_type; ?>"><?php echo $message; ?></div>
  <?php } ?>

  <div class="summary-box">
    <p>Total Cost: <strong>₱<?php echo number_format($booking['total_cost'], 2); ?></strong></p>
    <p>Total Paid: <strong>₱<?php echo number_format($total_paid, 2); ?></strong></p>
    <p class="balance">Balance Due: ₱<?php echo number_format($balance, 2); ?></p>
  </div>

  <?php if ($balance > 0) { ?>
    <form method="post">
      <label>Amount to Pay (₱)</label>
      <input type="number" name="amount_paid" step="0.01" min="0.01"
             max="<?php echo $balance; ?>" placeholder="0.00">

      <label>Payment Method</label>
      <select name="method">
        <option value="CASH">Cash</option>
        <option value="GCASH">GCash</option>
        <option value="CARD">Card</option>
      </select>

      <button type="submit" name="pay">Save Payment</button>
    </form>
  <?php } else { ?>
    <div class="alert alert-success">This booking is fully paid.</div>
  <?php } ?>
</div>
</body>
</html>
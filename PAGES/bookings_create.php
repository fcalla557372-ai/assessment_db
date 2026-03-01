<?php
include "../db.php";

$message = "";

if (isset($_POST['create'])) {
  $client_id    = intval($_POST['client_id']);
  $service_id   = intval($_POST['service_id']);
  $booking_date = $_POST['booking_date'];
  $hours        = intval($_POST['hours']);

  if ($client_id <= 0 || $service_id <= 0 || $booking_date == "" || $hours <= 0) {
    $message = "All fields are required. Please fill in every field before submitting.";
  } else {
    $s     = mysqli_fetch_assoc(mysqli_query($conn, "SELECT hourly_rate FROM services WHERE service_id=$service_id"));
    $rate  = $s['hourly_rate'];
    $total = $rate * $hours;

    mysqli_query($conn, "INSERT INTO bookings (client_id, service_id, booking_date, hours, hourly_rate_snapshot, total_cost, status)
      VALUES ($client_id, $service_id, '$booking_date', $hours, $rate, $total, 'PENDING')");

    header("Location: bookings_list.php");
    exit;
  }
}

$clients  = mysqli_query($conn, "SELECT * FROM clients ORDER BY full_name ASC");
$services = mysqli_query($conn, "SELECT * FROM services WHERE is_active=1 ORDER BY service_name ASC");
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Create Booking</title>
  <link rel="stylesheet" href="../style.css">
</head>
<body>
<div class="wrapper">
  <?php include "../nav.php"; ?>

  <div class="page-bar">
    <h2>Create Booking</h2>
    <a href="bookings_list.php" class="btn btn-sm" style="background:#f0f2f5;color:#555;">← Back to Bookings</a>
  </div>

  <?php if ($message) { ?>
    <div class="alert alert-error"><?php echo $message; ?></div>
  <?php } ?>

  <form method="post">
    <label>Client</label>
    <select name="client_id">
      <option value="">-- Select Client --</option>
      <?php while ($c = mysqli_fetch_assoc($clients)) { ?>
        <option value="<?php echo $c['client_id']; ?>"
          <?php if (isset($_POST['client_id']) && $_POST['client_id'] == $c['client_id']) echo 'selected'; ?>>
          <?php echo htmlspecialchars($c['full_name']); ?>
        </option>
      <?php } ?>
    </select>

    <label>Service</label>
    <select name="service_id">
      <option value="">-- Select Service --</option>
      <?php while ($s = mysqli_fetch_assoc($services)) { ?>
        <option value="<?php echo $s['service_id']; ?>"
          <?php if (isset($_POST['service_id']) && $_POST['service_id'] == $s['service_id']) echo 'selected'; ?>>
          <?php echo htmlspecialchars($s['service_name']); ?> — ₱<?php echo number_format($s['hourly_rate'], 2); ?>/hr
        </option>
      <?php } ?>
    </select>

    <label>Booking Date</label>
    <input type="date" name="booking_date"
      value="<?php echo isset($_POST['booking_date']) ? htmlspecialchars($_POST['booking_date']) : ''; ?>">

    <label>Number of Hours</label>
    <input type="number" name="hours" min="1"
      value="<?php echo isset($_POST['hours']) ? intval($_POST['hours']) : 1; ?>">

    <button type="submit" name="create">Create Booking</button>
  </form>
</div>
</body>
</html>
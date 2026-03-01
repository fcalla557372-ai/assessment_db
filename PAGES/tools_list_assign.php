<?php
include "../db.php";

$message      = "";
$message_type = "success";

if (isset($_POST['assign'])) {
  $booking_id = isset($_POST['booking_id']) ? intval($_POST['booking_id']) : 0;
  $tool_id    = isset($_POST['tool_id'])    ? intval($_POST['tool_id'])    : 0;
  $qty        = isset($_POST['qty_used'])   ? intval($_POST['qty_used'])   : 0;

  if ($booking_id <= 0 || $tool_id <= 0 || $qty <= 0) {
    $message      = "Please select a valid booking, tool, and quantity.";
    $message_type = "error";
  } else {
    $toolRow = mysqli_fetch_assoc(mysqli_query($conn, "SELECT quantity_available FROM tools WHERE tool_id=$tool_id"));

    if ($qty > $toolRow['quantity_available']) {
      $message      = "Not enough available tools!";
      $message_type = "error";
    } else {
      mysqli_query($conn, "INSERT INTO booking_tools (booking_id, tool_id, qty_used)
        VALUES ($booking_id, $tool_id, $qty)");
      mysqli_query($conn, "UPDATE tools SET quantity_available = quantity_available - $qty WHERE tool_id=$tool_id");
      $message = "Tool assigned successfully!";
    }
  }
}

$tools    = mysqli_query($conn, "SELECT * FROM tools ORDER BY tool_name ASC");
$bookings = mysqli_query($conn, "SELECT booking_id FROM bookings ORDER BY booking_id DESC");
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Tools &amp; Inventory</title>
  <link rel="stylesheet" href="../style.css">
</head>
<body>
<div class="wrapper">
  <?php include "../nav.php"; ?>

  <div class="page-bar">
    <h2>Tools &amp; Inventory</h2>
  </div>

  <?php if ($message) { ?>
    <div class="alert alert-<?php echo $message_type; ?>"><?php echo $message; ?></div>
  <?php } ?>

  <h3>Available Tools</h3>
  <table>
    <thead>
      <tr>
        <th>Tool Name</th>
        <th>Total Qty</th>
        <th>Available</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($t = mysqli_fetch_assoc($tools)) { ?>
        <tr>
          <td><?php echo htmlspecialchars($t['tool_name']); ?></td>
          <td><?php echo $t['quantity_total']; ?></td>
          <td>
            <?php
              $avail = $t['quantity_available'];
              $class = $avail > 0 ? 'badge-success' : 'badge-danger';
              echo "<span class=\"badge $class\">$avail</span>";
            ?>
          </td>
        </tr>
      <?php } ?>
    </tbody>
  </table>

  <hr>

  <h3>Assign Tool to Booking</h3>

  <form method="post">
    <label>Booking</label>
    <select name="booking_id">
      <option value="">-- Select Booking --</option>
      <?php while ($b = mysqli_fetch_assoc($bookings)) { ?>
        <option value="<?php echo $b['booking_id']; ?>">Booking #<?php echo $b['booking_id']; ?></option>
      <?php } ?>
    </select>

    <label>Tool</label>
    <select name="tool_id">
      <?php
        $tools2 = mysqli_query($conn, "SELECT * FROM tools ORDER BY tool_name ASC");
        while ($t2 = mysqli_fetch_assoc($tools2)) {
      ?>
        <option value="<?php echo $t2['tool_id']; ?>">
          <?php echo htmlspecialchars($t2['tool_name']); ?> — Available: <?php echo $t2['quantity_available']; ?>
        </option>
      <?php } ?>
    </select>

    <label>Quantity to Use</label>
    <input type="number" name="qty_used" min="1" value="1">

    <button type="submit" name="assign">Assign Tool</button>
  </form>
</div>
</body>
</html>
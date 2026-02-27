<?php
include "../db.php";

$message = "";

if (isset($_POST['save'])) {
  $full_name = $_POST['full_name'];
  $email     = $_POST['email'];
  $phone     = $_POST['phone'];
  $address   = $_POST['address'];

  if ($full_name == "" || $email == "") {
    $message = "Name and Email are required!";
  } else {
    $sql = "INSERT INTO clients (full_name, email, phone, address)
            VALUES ('$full_name', '$email', '$phone', '$address')";
    mysqli_query($conn, $sql);
    header("Location: clients_list.php");
    exit;
  }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Add Client</title>
  <link rel="stylesheet" href="../style.css">
</head>
<body>
<div class="wrapper">
  <?php include "../nav.php"; ?>

  <div class="page-bar">
    <h2>Add Client</h2>
    <a href="clients_list.php" class="btn btn-sm" style="background:#f0f2f5;color:#555;">← Back to Clients</a>
  </div>

  <?php if ($message) { ?>
    <div class="alert alert-error"><?php echo $message; ?></div>
  <?php } ?>

  <form method="post">
    <label>Full Name <span style="color:#e74c3c;">*</span></label>
    <input type="text" name="full_name" placeholder="e.g. Juan Dela Cruz">

    <label>Email <span style="color:#e74c3c;">*</span></label>
    <input type="email" name="email" placeholder="email@example.com">

    <label>Phone</label>
    <input type="text" name="phone" placeholder="+63 900 000 0000">

    <label>Address</label>
    <input type="text" name="address" placeholder="Street, City">

    <button type="submit" name="save">Save Client</button>
  </form>
</div>
</body>
</html>
<?php
include "../db.php";

$id  = $_GET['id'];
$get = mysqli_query($conn, "SELECT * FROM clients WHERE client_id = $id");
$client = mysqli_fetch_assoc($get);

$message = "";

if (isset($_POST['update'])) {
  $full_name = $_POST['full_name'];
  $email     = $_POST['email'];
  $phone     = $_POST['phone'];
  $address   = $_POST['address'];

  if ($full_name == "" || $email == "") {
    $message = "Name and Email are required!";
  } else {
    $sql = "UPDATE clients
            SET full_name='$full_name', email='$email', phone='$phone', address='$address'
            WHERE client_id=$id";
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
  <title>Edit Client</title>
  <link rel="stylesheet" href="../style.css">
</head>
<body>
<div class="wrapper">
  <?php include "../nav.php"; ?>

  <div class="page-bar">
    <h2>Edit Client</h2>
    <a href="clients_list.php" class="btn btn-sm" style="background:#f0f2f5;color:#555;">← Back to Clients</a>
  </div>

  <?php if ($message) { ?>
    <div class="alert alert-error"><?php echo $message; ?></div>
  <?php } ?>

  <form method="post">
    <label>Full Name <span style="color:#e74c3c;">*</span></label>
    <input type="text" name="full_name" value="<?php echo htmlspecialchars($client['full_name']); ?>">

    <label>Email <span style="color:#e74c3c;">*</span></label>
    <input type="email" name="email" value="<?php echo htmlspecialchars($client['email']); ?>">

    <label>Phone</label>
    <input type="text" name="phone" value="<?php echo htmlspecialchars($client['phone']); ?>">

    <label>Address</label>
    <input type="text" name="address" value="<?php echo htmlspecialchars($client['address']); ?>">

    <button type="submit" name="update">Update Client</button>
  </form>
</div>
</body>
</html>
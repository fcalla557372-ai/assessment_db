<?php
session_start();

if (isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username === "admin" && $password === "admin") {

        $_SESSION['username'] = "ADMIN";
        header("Location: index.php");
        exit();

    } else {
        $error = "Invalid username or password!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Login</title>
  <link rel="stylesheet" href="style.css">
</head>
<body class="login-page">

  <div class="login-box">

    <?php if ($error != ""): ?>
      <div class="alert alert-error"><?php echo $error; ?></div>
    <?php endif; ?>

    <div class="login-form">
      <form method="POST">
        <label>Username</label>
        <input type="text" name="username" placeholder="Enter your username" required autofocus>

        <label>Password</label>
        <input type="password" name="password" placeholder="Enter your password" required>

        <button type="submit">Log In</button>
      </form>
    </div>
  </div>

</body>
</html>
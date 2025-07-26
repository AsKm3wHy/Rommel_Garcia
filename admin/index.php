<?php
session_start();
require_once 'config/database.php';

// If already logged in, redirect to dashboard
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: dashboard.php');
    exit;
}

$error = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $database = new Database();
    $db = $database->getConnection();
    $stmt = $db->prepare('SELECT * FROM admin_users WHERE username = ? LIMIT 1');
    $stmt->execute([$username]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $admin['username'];
        header('Location: dashboard.php');
        exit;
    } else {
        $error = true;
    }
} elseif (isset($_GET['error'])) {
    $error = true;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login | Rommel Garcia Digital Video & Photography</title>
  <link rel="icon" href="img/rommel-logo.png">
  <style>
    @import url('https://fonts.googleapis.com/css?family=Montserrat:400,800');
    body {
      background: #f6f6f6;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
      font-family: 'Montserrat', sans-serif;
    }
    .container {
      background: #fff;
      border-radius: 10px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.08);
      padding: 40px 30px 30px 30px;
      max-width: 400px;
      width: 100%;
      text-align: center;
    }
    .container img {
      width: 80px;
      margin-bottom: 18px;
    }
    h2 {
      margin: 0 0 18px 0;
      color: #1976d2;
      font-weight: 800;
      font-size: 2rem;
      letter-spacing: 1px;
    }
    form {
      display: flex;
      flex-direction: column;
      gap: 18px;
    }
    input[type="text"], input[type="password"] {
      padding: 12px 16px;
      border: 1.5px solid #b0b8c1;
      border-radius: 6px;
      font-size: 1em;
      outline: none;
      transition: border 0.2s, box-shadow 0.2s;
    }
    input[type="text"]:focus, input[type="password"]:focus {
      border: 1.5px solid #1976d2;
      box-shadow: 0 2px 8px rgba(25, 118, 210, 0.10);
    }
    button[type="submit"] {
      background: #1976d2;
      color: #fff;
      border: none;
      border-radius: 6px;
      padding: 12px 0;
      font-size: 1.1em;
      font-weight: bold;
      cursor: pointer;
      transition: background 0.2s;
      margin-top: 8px;
    }
    button[type="submit"]:hover {
      background: #1256a3;
    }
    .footer {
      margin-top: 24px;
      color: #aaa;
      font-size: 0.95em;
    }
    .error {
      color: #c62828;
      background: #ffebee;
      border-radius: 6px;
      padding: 10px 0;
      margin-bottom: 12px;
      font-weight: 600;
      font-size: 1em;
    }
  </style>
</head>
<body>
  <div class="container">
    <img src="img/rommel-logo.png" alt="Rommel Garcia Logo">
    <h2>Admin Login</h2>
    <?php if ($error): ?>
      <div class="error">Invalid username or password.</div>
    <?php endif; ?>
    <form method="post" action="index.php">
      <input type="text" name="username" placeholder="Username" required autocomplete="username">
      <input type="password" name="password" placeholder="Password" required autocomplete="current-password">
      <button type="submit">Login</button>
    </form>
    <div class="footer">&copy; Rommel Garcia Digital Video & Photography</div>
  </div>
</body>
</html> 
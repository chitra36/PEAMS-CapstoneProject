<?php
session_start();
include 'includes/config.php';

$error = "";

if (isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = md5(trim($_POST['password'])); // Encrypt input

    $sql = "SELECT * FROM users WHERE Email = '$email' AND Password = '$password'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows == 1) {
        $user = $result->fetch_assoc();
        $_SESSION['user'] = $user;

        if ($user['Role'] === 'admin') {
            header("Location: admin/dashboard.php");
        } elseif ($user['Role'] === 'employee') {
            header("Location: employee/dashboard.php");
        }
        exit();
    } else {
        $error = "❌ Invalid credentials.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Login - PEAMS</title>
<style>
  body {
    margin: 0;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: #f0f4f8;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
  }
  .login-box {
    background: white;
    padding: 40px 35px;
    border-radius: 12px;
    box-shadow: 0 6px 18px rgba(0,0,0,0.1);
    width: 100%;
    max-width: 400px;
  }
  h2 {
    text-align: center;
    color: #0056b3;
    margin-bottom: 30px;
  }
  input[type="email"],
  input[type="password"] {
    width: 100%;
    padding: 14px 15px;
    margin: 10px 0 20px 0;
    border: 1.8px solid #ddd;
    border-radius: 8px;
    font-size: 1rem;
    transition: border-color 0.3s ease;
    box-sizing: border-box;
  }
  input[type="email"]:focus,
  input[type="password"]:focus {
    outline: none;
    border-color: #007bff;
  }
  button {
    width: 100%;
    padding: 14px;
    background-color: #007bff;
    border: none;
    border-radius: 8px;
    color: white;
    font-size: 1.1rem;
    font-weight: 600;
    cursor: pointer;
    transition: background-color 0.3s ease;
  }
  button:hover {
    background-color: #0056b3;
  }
  p.error {
    background-color: #f8d7da;
    color: #842029;
    padding: 12px 15px;
    border-radius: 8px;
    font-weight: 600;
    margin-bottom: 20px;
    text-align: center;
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
  }
  .link-box {
    text-align: center;
    margin-top: 20px;
  }
  .link-box a {
    display: inline-block;
    margin: 6px 8px;
    text-decoration: none;
    font-weight: 500;
    color: #007bff;
    transition: color 0.3s ease;
  }
  .link-box a:hover {
    color: #0056b3;
  }
</style>
</head>
<body>

<div class="login-box">
  <h2>🔐 Login to PEAMS</h2>

  <?php if ($error): ?>
    <p class="error"><?= htmlspecialchars($error) ?></p>
  <?php endif; ?>

  <form method="POST" novalidate>
    <input type="email" name="email" placeholder="Email" required autocomplete="email" />
    <input type="password" name="password" placeholder="Password" required autocomplete="current-password" />
    <button type="submit" name="login">Login</button>
  </form>

  <div class="link-box">
    <a href="register.php">📝 New user? Register here</a><br>
    <a href="forgot_password.php">🔑 Forgot Password?</a>
  </div>
</div>

</body>
</html>

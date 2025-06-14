<?php
session_start();
include 'includes/config.php';

$error = "";

if (isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = md5(trim($_POST['password']));

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
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login - PEAMS</title>
  <style>
    * {
      box-sizing: border-box;
    }

    body {
    margin: 0;
    font-family: 'Segoe UI', sans-serif;
    background: linear-gradient(135deg, #cdeaff, #f6fafd);
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
  }
  .reset-box {
    background: rgba(255, 255, 255, 0.15);
    padding: 40px 35px;
    border-radius: 20px;
    backdrop-filter: blur(10px);
    box-shadow: 0 8px 32px rgba(31, 38, 135, 0.37);
    border: 1px solid rgba(255, 255, 255, 0.18);
    width: 100%;
    max-width: 420px;
  }
  h2 {
    text-align: center;
    color: black;
    margin-bottom: 30px;
  }
  input {
    width: 100%;
    padding: 14px;
    margin: 10px 0 20px 0;
    border: none;
    border-radius: 50px;
    font-size: 1rem;
    background: rgba(255, 255, 255, 0.8);
    color: #333;
    box-sizing: border-box;
  }
  input::placeholder {
    color: #666;
  }
  input:focus {
    outline: none;
  }
  button {
    width: 100%;
    padding: 14px;
   background: linear-gradient(to right, #a1c4fd, #c2e9fb);
    border: none;
    border-radius: 50px;
    color: black;
    font-size: 1.1rem;
    font-weight: 600;
    cursor: pointer;
  }
  button:hover {
    background: linear-gradient(to right, #c2e9fb, #a1c4fd);
  }
  p.message {
    text-align: center;
    font-weight: 600;
    padding: 10px;
    border-radius: 8px;
    margin-bottom: 20px;
  }
  .success {
    background-color: #d4edda;
    color: #155724;
  }
  .error {
    background-color: #f8d7da;
    color: #721c24;
  }
  .link-box {
    text-align: center;
    margin-top: 15px;
  }
  .link-box a {
    color: blue;
    text-decoration: none;
    font-weight: 500;
  }
  .link-box a:hover {
    color: #0056b3;
  }
  </style>
</head>
<body>

  <div class="login-container">
    <h2>Login</h2>

    <?php if ($error): ?>
      <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="POST" novalidate>
      <input type="email" name="email" placeholder="Username" required autocomplete="email" />
      <input type="password" name="password" placeholder="Password" required autocomplete="current-password" />
      <button type="submit" name="login">Button</button>
    </form>

    <div class="link-box">
      <a href="register.php">📝 Register</a>
      <a href="forgot_password.php">🔑 Forgot Password?</a>
    </div>
  </div>

</body>
</html>

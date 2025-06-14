<?php
include 'includes/config.php';
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $newPassword = trim($_POST['new_password']);

    if (!empty($email) && !empty($newPassword)) {
        $hashedPassword = md5($newPassword); // Use password_hash() in production

        $sql = "UPDATE users SET Password = '$hashedPassword' WHERE Email = '$email'";
        if ($conn->query($sql) && $conn->affected_rows > 0) {
            $message = "✅ Password successfully updated. You can now login.";
        } else {
            $message = "❌ Email not found.";
        }
    } else {
        $message = "❌ Please fill in all fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Reset Password - PEAMS</title>
  <style>
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
      backdrop-filter: blur(10px);
      border-radius: 25px;
      padding: 40px 35px;
      width: 100%;
      max-width: 420px;
      box-shadow: 0 8px 32px rgba(31, 38, 135, 0.2);
      border: 1px solid rgba(255, 255, 255, 0.3);
    }

    h2 {
      text-align: center;
      color: #2c3e50;
      margin-bottom: 30px;
    }

    input {
      width: 100%;
      padding: 14px;
      margin-bottom: 20px;
      border: none;
      border-radius: 50px;
      font-size: 1rem;
      background: rgba(255, 255, 255, 0.85);
      color: #333;
      outline: none;
    }

    input::placeholder {
      color: #888;
    }

    button {
      width: 100%;
      padding: 14px;
      background: linear-gradient(to right, #a1c4fd, #c2e9fb);
      border: none;
      border-radius: 50px;
      color: #2c3e50;
      font-size: 1.1rem;
      font-weight: bold;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    button:hover {
      background: linear-gradient(to right, #c2e9fb, #a1c4fd);
    }

    p.message {
      text-align: center;
      font-weight: 600;
      padding: 10px;
      border-radius: 6px;
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
      color: #007bff;
      text-decoration: none;
      font-weight: 500;
    }

    .link-box a:hover {
      color: #0056b3;
    }
  </style>
</head>
<body>

<div class="reset-box">
  <h2>🔐 Reset Your Password</h2>

  <?php if ($message): ?>
    <p class="message <?= strpos($message, '✅') !== false ? 'success' : 'error' ?>">
      <?= $message ?>
    </p>
  <?php endif; ?>

  <form method="POST" novalidate>
    <input type="email" name="email" placeholder="Enter your registered email" required />
    <input type="password" name="new_password" placeholder="Enter your new password" required />
    <button type="submit">Reset Password</button>
  </form>

  <div class="link-box">
    <a href="index.php">🔙 Back to Login</a>
  </div>
</div>

</body>
</html>

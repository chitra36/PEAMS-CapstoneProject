<?php
include 'includes/config.php';
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $newPassword = trim($_POST['new_password']);

    if (!empty($email) && !empty($newPassword)) {
        $hashedPassword = md5($newPassword); // Basic encryption (you can upgrade to password_hash later)

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
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: #f0f4f8;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .reset-box {
      background: white;
      padding: 40px 35px;
      border-radius: 12px;
      box-shadow: 0 6px 18px rgba(0,0,0,0.1);
      width: 100%;
      max-width: 420px;
    }
    h2 {
      text-align: center;
      color: #dc3545;
      margin-bottom: 30px;
    }
    input {
      width: 100%;
      padding: 14px 15px;
      margin: 10px 0 20px 0;
      border: 1.8px solid #ddd;
      border-radius: 8px;
      font-size: 1rem;
      box-sizing: border-box;
      transition: border-color 0.3s ease;
    }
    input:focus {
      border-color: #dc3545;
    }
    button {
      width: 100%;
      padding: 14px;
      background-color: #dc3545;
      border: none;
      border-radius: 8px;
      color: white;
      font-size: 1.1rem;
      font-weight: 600;
      cursor: pointer;
    }
    button:hover {
      background-color: #bd2130;
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

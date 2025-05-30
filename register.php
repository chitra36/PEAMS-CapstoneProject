<?php
session_start();
include 'includes/config.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string(trim($_POST['name']));
    $email = $conn->real_escape_string(trim($_POST['email']));
    $password = md5(trim($_POST['password']));
    $role = $conn->real_escape_string($_POST['role']);

    $check = $conn->query("SELECT * FROM users WHERE Email = '$email'");
    if ($check->num_rows > 0) {
        $message = "❌ Email already registered!";
    } else {
        $sql = "INSERT INTO users (Name, Email, Password, Role) VALUES ('$name', '$email', '$password', '$role')";
        if ($conn->query($sql)) {
            $message = "✅ Registration successful! You can now login.";
        } else {
            $message = "❌ Error: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Register - PEAMS</title>
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

    .register-box {
      background: white;
      padding: 40px 35px;
      border-radius: 12px;
      box-shadow: 0 6px 18px rgba(0,0,0,0.1);
      width: 100%;
      max-width: 450px;
    }

    h2 {
      text-align: center;
      color: #28a745;
      margin-bottom: 30px;
    }

    input[type="text"],
    input[type="email"],
    input[type="password"] {
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
      outline: none;
      border-color: #28a745;
    }

    button {
      width: 100%;
      padding: 14px;
      background-color: #28a745;
      border: none;
      border-radius: 8px;
      color: white;
      font-size: 1.1rem;
      font-weight: 600;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    button:hover {
      background-color: #218838;
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
    select {
  width: 100%;
  padding: 14px 15px;
  margin: 10px 0 20px 0;
  border: 1.8px solid #ddd;
  border-radius: 8px;
  font-size: 1rem;
  box-sizing: border-box;
  background-color: white;
  color: #333;
  transition: border-color 0.3s ease;
  appearance: none;
}

select:focus {
  outline: none;
  border-color: #28a745;
}

  </style>
</head>
<body>

<div class="register-box">
  <h2>📝 Register to PEAMS</h2>

  <?php if ($message): ?>
    <p class="message <?= strpos($message, 'successful') !== false ? 'success' : 'error' ?>">
      <?= htmlspecialchars($message) ?>
    </p>
  <?php endif; ?>

  <form method="POST" novalidate>
    <input type="text" name="name" placeholder="Full Name" required />
    <input type="email" name="email" placeholder="Email Address" required />
    <input type="password" name="password" placeholder="Create Password" required />

     <label for="role">Select Role</label>
<select name="role" id="role" required>
    <option value="">-- Choose Role --</option>
    <option value="employee">Employee</option>
    <option value="admin">Admin</option>
</select>

    <button type="submit">Register</button>
  </form>

  <div class="link-box">
    <a href="index.php">🔑 Already have an account? Login</a>
  </div>
</div>

</body>
</html>

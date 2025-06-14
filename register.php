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
  padding: 0;
  font-family: 'Segoe UI', sans-serif;
  background: linear-gradient(135deg, #c1dffb, #e8f4fd);
  height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
}

.register-box {
  background: rgba(255, 255, 255, 0.75);
  backdrop-filter: blur(10px);
  border-radius: 16px;
  padding: 40px 35px;
  box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
  max-width: 400px;
  width: 100%;
  margin: 50px 0; /* gap from top and bottom */
}

h2 {
  text-align: center;
  color: #2a3f54;
  margin-bottom: 25px;
  font-size: 22px;
}

input[type="text"],
input[type="email"],
input[type="password"],
select {
  width: 100%;
  padding: 12px 15px;
  margin: 12px 0;
  border: 1px solid #d0dfea;
  border-radius: 8px;
  background-color: #f9fcff;
  font-size: 15px;
  color: #333;
  transition: border 0.3s ease;
}

input:focus,
select:focus {
  outline: none;
  border-color: #7fbfff;
  box-shadow: 0 0 3px #a9d4ff;
}

button {
  width: 100%;
  padding: 12px;
  background-color: #4a90e2;
  color: white;
  font-size: 16px;
  border: none;
  border-radius: 8px;
  margin-top: 20px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

button:hover {
  background-color: #3b7dc1;
}

p.message {
  text-align: center;
  font-weight: 500;
  padding: 10px;
  border-radius: 6px;
  font-size: 0.95rem;
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
  margin-top: 18px;
}

.link-box a {
  text-decoration: none;
  color: #4a90e2;
  font-weight: 500;
}

.link-box a:hover {
  color: #3b7dc1;
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

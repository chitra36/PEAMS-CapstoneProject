<?php
session_start();
include '../includes/config.php';
include '../includes/header.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['Role'] !== 'employee') {
    header("Location: ../index.php");
    exit();
}

$user_id = $_SESSION['user']['ID'];
$date = date('Y-m-d');
$time = date('H:i:s');
$status = 'Present';

$sqlCheck = "SELECT * FROM attendance WHERE User_ID = $user_id AND Date = '$date'";
$result = $conn->query($sqlCheck);

if ($result->num_rows == 0) {
    $sql = "INSERT INTO attendance (User_ID, Date, Time, Status) VALUES ($user_id, '$date', '$time', '$status')";
    if ($conn->query($sql)) {
        $message = "✅ Attendance marked for <strong>$date</strong> at <strong>$time</strong>.";
        $msgClass = "success";
    } else {
        $message = "❌ Error: " . $conn->error;
        $msgClass = "error";
    }
} else {
    $message = "⚠️ Attendance already marked for today.";
    $msgClass = "warning";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Mark Attendance</title>
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: #f4f6f8;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    /* main {
      flex: 1;
      display: flex;
      justify-content: center;
      align-items: center;
    } */

    .container {
      background: #fff;
      padding: 40px;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      text-align: center;
      max-width: 500px;
      width: 90%;
    }

    h2 {
      color: #007bff;
      margin-bottom: 20px;
    }

    .message {
      padding: 15px;
      margin-bottom: 20px;
      border-radius: 8px;
      font-size: 1rem;
      font-weight: 500;
    }

    .success {
      background-color: #d4edda;
      color: #155724;
      border: 1px solid #c3e6cb;
    }

    .error {
      background-color: #f8d7da;
      color: #721c24;
      border: 1px solid #f5c6cb;
    }

    .warning {
      background-color: #fff3cd;
      color: #856404;
      border: 1px solid #ffeeba;
    }

    a.button {
      display: inline-block;
      margin-top: 20px;
      padding: 12px 25px;
      background-color: #007bff;
      color: white;
      text-decoration: none;
      font-weight: bold;
      border-radius: 6px;
      transition: background-color 0.3s ease;
    }

    a.button:hover {
      background-color: #0056b3;
    }

    footer {
      background-color: #f1f1f1;
      padding: 15px;
      text-align: center;
      font-size: 0.9rem;
      color: #555;
      border-top: 1px solid #ddd;
    }
  </style>
</head>
<body>

<main>
  <div class="container">
    <h2>🕒 Mark Attendance</h2>
    <div class="message <?= $msgClass ?>"><?= $message ?></div>
    <a href="dashboard.php" class="button">🔙 Back to Dashboard</a>
  </div>
</main>
<!-- <div class="alert alert-success">✅ Attendance marked!</div> -->

<?php include '../includes/footer.php'; ?>
</body>
</html>

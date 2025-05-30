<?php
session_start();
include '../includes/config.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['Role'] !== 'employee') {
    header("Location: ../index.php");
    exit();
}

$user_id = $_SESSION['user']['ID'];
$leave_id = intval($_GET['id']);

// Check leave belongs to user and is pending
$sql = "SELECT * FROM leave_requests WHERE ID = $leave_id AND User_ID = $user_id AND Status = 'Pending' AND Cancelled = 0";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $conn->query("UPDATE leave_requests SET Cancelled = 1 WHERE ID = $leave_id");
    $msg = "✅ Leave cancelled.";
} else {
    $msg = "⚠️ Cannot cancel this leave.";
}

header("Location: my_leaves.php?msg=" . urlencode($msg));
exit();

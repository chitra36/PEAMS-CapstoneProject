<?php
session_start();
include '../includes/config.php';
include '../includes/header.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['Role'] !== 'employee') {
    header("Location: ../index.php");
    exit();
}

$user_id = $_SESSION['user']['ID'];

$sql = "SELECT * FROM leave_requests WHERE User_ID = $user_id ORDER BY ID DESC";
$result = $conn->query($sql);

// Leave Count
$year = date('Y');
$sqlCount = "SELECT COUNT(*) as total FROM leave_requests 
    WHERE User_ID = $user_id AND Status = 'Approved' AND Cancelled = 0 
    AND YEAR(From_Date) = $year";
$countResult = $conn->query($sqlCount)->fetch_assoc();

$totalLeaves = 20;
$usedLeaves = $countResult['total'];
$remainingLeaves = $totalLeaves - $usedLeaves;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>My Leave Requests</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f7f9fc;
            margin: 20px;
            color: #333;
        }
        h2 {
            color: #004085;
            margin-bottom: 0;
        }
        h3 {
            color: #383d41;
            margin-top: 5px;
            font-weight: 600;
        }
        .summary {
            background: #e2e3e5;
            padding: 15px 25px;
            border-radius: 8px;
            max-width: 400px;
            margin: 15px 0 30px;
            box-shadow: 0 2px 6px rgb(0 0 0 / 0.1);
        }
        .summary p {
            margin: 8px 0;
            font-size: 1rem;
            font-weight: 500;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            max-width: 900px;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgb(0 0 0 / 0.1);
        }
        th, td {
            padding: 14px 20px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background: #007bff;
            color: white;
            font-weight: 600;
        }
        tr:hover {
            background-color: #f1f8ff;
        }
        td a {
            color: #dc3545;
            font-weight: 600;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        td a:hover {
            color: #a71d2a;
        }
        .status {
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 0.95rem;
            padding: 6px 12px;
            border-radius: 20px;
        }
        .status.cancelled {
            background: #f8d7da;
            color: #721c24;
        }
        .status.pending {
            background: #fff3cd;
            color: #856404;
        }
        .status.approved {
            background: #d4edda;
            color: #155724;
        }
        .status.rejected {
            background: #f8d7da;
            color: #721c24;
        }
        @media (max-width: 600px) {
            body {
                margin: 10px;
            }
            table, .summary {
                width: 100%;
                max-width: 100%;
            }
            th, td {
                padding: 10px 12px;
            }
        }
    </style>
</head>
<body>

    <h2>📋 My Leave Requests</h2>
    <h3>🧾 Leave Summary (<?= $year ?>)</h3>
    <div class="summary">
        <p>Total Leaves Allowed: <strong><?= $totalLeaves ?></strong></p>
        <p>Leaves Used: <strong><?= $usedLeaves ?></strong></p>
        <p>Remaining Leaves: <strong><?= $remainingLeaves ?></strong></p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Reason</th>
                <th>From</th>
                <th>To</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['Reason']) ?></td>
                <td><?= $row['From_Date'] ?></td>
                <td><?= $row['To_Date'] ?></td>
                <td>
                    <?php
                        $statusClass = '';
                        $statusText = '';
                        if ($row['Cancelled']) {
                            $statusClass = 'cancelled';
                            $statusText = "🚫 Cancelled";
                        } elseif ($row['Status'] == 'Pending') {
                            $statusClass = 'pending';
                            $statusText = "🕓 Pending";
                        } elseif ($row['Status'] == 'Approved') {
                            $statusClass = 'approved';
                            $statusText = "✅ Approved";
                        } else {
                            $statusClass = 'rejected';
                            $statusText = "❌ Rejected";
                        }
                        echo "<span class='status $statusClass'>$statusText</span>";
                    ?>
                </td>
                <td>
                    <?php if ($row['Status'] == 'Pending' && !$row['Cancelled']): ?>
                        <a href="cancel_leave.php?id=<?= $row['ID'] ?>" onclick="return confirm('Are you sure you want to cancel this leave request?');">Cancel</a>
                    <?php else: ?>
                        ---
                    <?php endif; ?>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>

</body>
</html>
<?php include '../includes/footer.php'; ?>
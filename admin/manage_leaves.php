<?php
session_start();
include '../includes/config.php';
include '../includes/header.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['Role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

// Handle action
if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $action = $_GET['action'];

    if (in_array($action, ['Approved', 'Rejected'])) {
        $conn->query("UPDATE leave_requests SET Status = '$action' WHERE ID = $id");
    }
}

// Fetch leave requests
$sql = "SELECT lr.ID, u.Name, lr.Reason, lr.From_Date, lr.To_Date, lr.Status
        FROM leave_requests lr
        JOIN users u ON lr.User_ID = u.ID
        ORDER BY lr.ID DESC";
$result = $conn->query($sql);
?>

<div class="card shadow p-4 mb-5 bg-white rounded">
    <h2 class="text-primary mb-4"><i class="fas fa-calendar-check"></i> Manage Leave Requests</h2>

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle text-center">
            <thead class="table-dark">
                <tr>
                    <th>👤 Employee</th>
                    <th>📝 Reason</th>
                    <th>📅 From</th>
                    <th>📅 To</th>
                    <th>📌 Status</th>
                    <th>⚙️ Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['Name']) ?></td>
                        <td><?= htmlspecialchars($row['Reason']) ?></td>
                        <td><?= $row['From_Date'] ?></td>
                        <td><?= $row['To_Date'] ?></td>
                        <td>
                            <?php
                                $badge = match($row['Status']) {
                                    'Pending' => 'warning',
                                    'Approved' => 'success',
                                    'Rejected' => 'danger',
                                    default => 'secondary',
                                };
                                echo "<span class='badge bg-$badge'>{$row['Status']}</span>";
                            ?>
                        </td>
                        <td>
                            <?php if ($row['Status'] === 'Pending'): ?>
                                <a href="?action=Approved&id=<?= $row['ID'] ?>" class="btn btn-sm btn-success me-1">
                                    <i class="fas fa-check-circle"></i> Approve
                                </a>
                                <a href="?action=Rejected&id=<?= $row['ID'] ?>" class="btn btn-sm btn-danger">
                                    <i class="fas fa-times-circle"></i> Reject
                                </a>
                            <?php else: ?>
                                <i class="text-muted"><?= $row['Status'] ?></i>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <a href="dashboard.php" class="btn btn-outline-primary mt-4">
        <i class="fas fa-arrow-left"></i> Back to Dashboard
    </a>
</div>

<?php include '../includes/footer.php'; ?>

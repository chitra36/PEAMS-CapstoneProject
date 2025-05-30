<?php
session_start();
include '../includes/config.php';
include '../includes/header.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['Role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

$sql = "SELECT a.*, u.Name FROM attendance a
        JOIN users u ON a.User_ID = u.ID
        ORDER BY a.Date DESC, u.Name ASC";

$result = $conn->query($sql);
?>

<div class="card shadow-sm p-4 mb-5 bg-white rounded">
    <h2 class="mb-4 text-primary">
        <i class="fas fa-clipboard-list"></i> All Employees Attendance Report
    </h2>

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle text-center">
            <thead class="table-dark">
                <tr>
                    <th>👤 Employee Name</th>
                    <th>📅 Date</th>
                    <th>⏰ Time</th>
                    <th>✅ Status</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['Name']) ?></td>
                        <td><?= $row['Date'] ?></td>
                        <td><?= $row['Time'] ?></td>
                        <td>
                            <?php
                            if ($row['Status'] === 'Present') {
                                echo '<span class="badge bg-success">Present</span>';
                            } elseif ($row['Status'] === 'Absent') {
                                echo '<span class="badge bg-danger">Absent</span>';
                            } else {
                                echo '<span class="badge bg-warning text-dark">Leave</span>';
                            }
                            ?>
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

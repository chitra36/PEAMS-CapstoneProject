<?php
session_start();
include '../includes/config.php';
include '../includes/header.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['Role'] !== 'employee') {
    header("Location: ../index.php");
    exit();
}

$user_id = $_SESSION['user']['ID'];

$sql = "SELECT * FROM attendance WHERE User_ID = $user_id ORDER BY Date DESC";
$result = $conn->query($sql);
?>

<div class="card shadow p-4 mb-5 bg-white rounded">
    <h2 class="text-primary mb-4"><i class="fas fa-calendar-alt"></i> My Attendance Report</h2>

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle text-center">
            <thead class="table-dark">
                <tr>
                    <th>📅 Date</th>
                    <th>⏰ Time</th>
                    <th>📌 Status</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['Date'] ?></td>
                        <td><?= $row['Time'] ?></td>
                        <td>
                            <?php
                            $badge = match($row['Status']) {
                                'Present' => 'success',
                                'Absent' => 'danger',
                                'Leave' => 'warning',
                                default => 'secondary',
                            };
                            echo "<span class='badge bg-$badge'>{$row['Status']}</span>";
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

<?php
session_start();
include '../includes/header.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['Role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

$adminName = $_SESSION['user']['Name'];
?>

<div class="row justify-content-center mt-5">
    <div class="col-md-8">
        <div class="card shadow-lg p-5 rounded-4 border-0 bg-white">
            <h2 class="mb-3 text-primary fw-bold d-flex align-items-center">
                <i class="fas fa-user-shield me-2"></i> Admin Dashboard
            </h2>
            <p class="fs-5 text-muted">👋 Welcome, <strong><?= htmlspecialchars($adminName) ?></strong>!</p>
            <hr class="mb-4">

            <div class="d-grid gap-3">
                <a href="manage_leaves.php" class="btn btn-outline-success d-flex justify-content-between align-items-center px-4 py-3 rounded-3 shadow-sm text-start">
                    <span><i class="fas fa-clipboard-check me-2"></i> Manage Leave Requests</span>
                    <i class="fas fa-chevron-right"></i>
                </a>

                <a href="attendance_report.php" class="btn btn-outline-info d-flex justify-content-between align-items-center px-4 py-3 rounded-3 shadow-sm text-start">
                    <span><i class="fas fa-table me-2"></i> View Attendance Report</span>
                    <i class="fas fa-chevron-right"></i>
                </a>

                <a href="../logout.php" class="btn btn-outline-danger d-flex justify-content-between align-items-center px-4 py-3 rounded-3 shadow-sm text-start">
                    <span><i class="fas fa-sign-out-alt me-2"></i> Logout</span>
                    <i class="fas fa-chevron-right"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>

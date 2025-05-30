<?php
session_start();
include '../includes/config.php';
include '../includes/header.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['Role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

$adminName = $_SESSION['user']['Name'];

// Get total employees
$totalEmployees = $conn->query("SELECT COUNT(*) AS total FROM users WHERE Role = 'employee'")->fetch_assoc()['total'];

// Present today
$today = date('Y-m-d');
$presentToday = $conn->query("SELECT COUNT(*) AS present FROM attendance WHERE Date = '$today'")->fetch_assoc()['present'];

// Pending leave requests
$pendingLeaves = $conn->query("SELECT COUNT(*) AS pending FROM leave_requests WHERE Status = 'Pending'")->fetch_assoc()['pending'];
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

<style>
  body.dark-mode {
    background-color: #1e1e2f;
    color: #f1f1f1;
  }

  .card.dark-mode {
    background-color: #2c2c3e;
    color: #fff;
  }

  .btn-outline-light {
    color: #fff;
    border-color: #fff;
  }

  .btn-outline-light:hover {
    background-color: #fff;
    color: #000;
  }

 #theme-toggle {
  font-size: 0.85rem;
  /* padding: 4px 12px; */
  line-height: 1.2;
}

#theme-toggle .small-icon {
  font-size: 0.9rem;
}

#theme-toggle .toggle-label {
  margin-left: 4px;
}

body.dark-mode #theme-toggle {
  background-color: #343a40;
  color: #fff;
  border-color: #ccc;
}

</style>

<div class="container mt-5">
  <div class="card shadow-lg p-5 rounded-4 border-0 bg-white">
    <h2 class="mb-3 text-primary fw-bold d-flex align-items-center">
      <i class="fas fa-user-shield me-2"></i> Admin Dashboard
    </h2>
    <p class="fs-5 text-muted">👋 Welcome, <strong><?= htmlspecialchars($adminName) ?></strong>!</p>
    <button id="theme-toggle" class="btn btn-outline-secondary btn-sm rounded-pill d-flex align-items-center gap-1 px-3 py-1 mb-3 float-end">
  <i class="fas fa-moon small-icon"></i> <span class="toggle-label">Dark</span>
</button>


    <hr class="mb-4">

    <!-- Summary Section -->
    <div class="row mb-4">
      <div class="col-md-4">
        <div class="card text-center shadow-sm p-3">
          <h5>👥 Total Employees</h5>
          <p class="display-6 fw-bold text-primary"><?= $totalEmployees ?></p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card text-center shadow-sm p-3">
          <h5>✅ Present Today</h5>
          <p class="display-6 fw-bold text-success"><?= $presentToday ?></p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card text-center shadow-sm p-3">
          <h5>📩 Pending Leave Requests</h5>
          <p class="display-6 fw-bold text-warning"><?= $pendingLeaves ?></p>
        </div>
      </div>
    </div>

    <!-- Navigation Buttons -->
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

<script>
 const toggleBtn = document.getElementById('theme-toggle');
const icon = toggleBtn.querySelector('i');

toggleBtn.addEventListener('click', () => {
  document.body.classList.toggle('dark-mode');
  document.querySelectorAll('.card').forEach(c => c.classList.toggle('dark-mode'));

  // Toggle icon
  if (document.body.classList.contains('dark-mode')) {
    icon.classList.remove('fa-moon');
    icon.classList.add('fa-sun');
    toggleBtn.innerHTML = '<i class="fas fa-sun"></i> Light Mode';
  } else {
    icon.classList.remove('fa-sun');
    icon.classList.add('fa-moon');
    toggleBtn.innerHTML = '<i class="fas fa-moon"></i> Dark Mode';
  }
});
</script>

<?php include '../includes/footer.php'; ?>

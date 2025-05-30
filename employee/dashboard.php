<?php
session_start();
include '../includes/config.php';
include '../includes/header.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['Role'] !== 'employee') {
    header("Location: ../index.php");
    exit();
}

$user = $_SESSION['user'];
?>

<!-- Tailwind CSS CDN -->
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

<div class="min-h-screen bg-gray-100 p-6">
    <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-md p-8">
        <!-- Header -->
        <div class="mb-6">
            <h2 class="text-3xl font-bold text-blue-600 flex items-center gap-2">
                <i class="fas fa-user"></i> Employee Dashboard
            </h2>
            <p class="text-lg text-gray-700 mt-2">👋 Welcome, <strong><?= htmlspecialchars($user['Name']) ?></strong>!</p>
        </div>

        <!-- Action Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <a href="mark_attendance.php" class="bg-green-100 hover:bg-green-200 text-green-700 font-semibold rounded-xl shadow p-5 flex items-center justify-between">
                ✅ Mark Attendance
                <i class="fas fa-clock text-xl"></i>
            </a>

            <a href="request_leave.php" class="bg-blue-100 hover:bg-blue-200 text-blue-700 font-semibold rounded-xl shadow p-5 flex items-center justify-between">
                📝 Request Leave
                <i class="fas fa-paper-plane text-xl"></i>
            </a>

            <a href="my_leaves.php" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl shadow p-5 flex items-center justify-between">
                📄 My Leave Status
                <i class="fas fa-file-alt text-xl"></i>
            </a>

            <a href="attendance_report.php" class="bg-yellow-100 hover:bg-yellow-200 text-yellow-700 font-semibold rounded-xl shadow p-5 flex items-center justify-between">
                ⏱ View My TimeSheet
                <i class="fas fa-chart-line text-xl"></i>
            </a>
        </div>

        <!-- Logout Button -->
        <div class="text-right">
            <a href="logout.php" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-6 rounded-full shadow inline-flex items-center gap-2">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>
    </div>
</div>


<!-- Font Awesome -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

<?php include '../includes/footer.php'; ?>

<?php
session_start();
include '../includes/config.php';
include '../includes/header.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['Role'] !== 'employee') {
    header("Location: ../index.php");
    exit();
}

$user_id = $_SESSION['user']['ID'];
$message = "";

if (isset($_POST['submit'])) {
    $reason = $conn->real_escape_string($_POST['reason']);
    $from = $_POST['from_date'];
    $to = $_POST['to_date'];

    $sql = "INSERT INTO leave_requests (User_ID, Reason, From_Date, To_Date)
            VALUES ($user_id, '$reason', '$from', '$to')";

    $message = $conn->query($sql) 
        ? "✅ Leave request submitted!" 
        : "❌ Error: " . $conn->error;
}
?>

<!-- Tailwind CSS CDN -->
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

<div class="min-h-screen bg-gray-100 flex flex-col items-center justify-center px-4 py-10">
    <div class="bg-white w-full max-w-2xl p-8 rounded-xl shadow-lg">
        <h2 class="text-2xl font-bold text-blue-600 mb-6 flex items-center gap-2">
            📝 Request Leave
        </h2>

        <?php if ($message): ?>
            <div class="mb-6 p-4 rounded-lg font-semibold text-center 
                <?= strpos($message, 'Error') === false 
                    ? 'bg-green-100 text-green-700' 
                    : 'bg-red-100 text-red-700' ?>">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <form method="POST" class="space-y-6">
    <div>
        <label for="reason" class="block font-medium text-gray-700">Comment / Reason <span class="text-red-500">*</span></label>
        <textarea id="reason" name="reason" required
                  class="w-full mt-2 p-3 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200 resize-none"
                  placeholder="Enter reason for leave..."></textarea>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="from_date" class="block font-medium text-gray-700">Start Date <span class="text-red-500">*</span></label>
            <input type="date" id="from_date" name="from_date" required
                   class="w-full mt-2 p-3 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200">
        </div>
        <div>
            <label for="to_date" class="block font-medium text-gray-700">End Date <span class="text-red-500">*</span></label>
            <input type="date" id="to_date" name="to_date" required
                   class="w-full mt-2 p-3 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200">
        </div>
    </div>

    <!-- ✅ Submit / Cancel -->
    <div class="flex justify-end gap-4 mt-8">
        <button type="submit" name="submit"
            class=" text-red-600 font-semibold py-2 px-4 hover:underline transition-all duration-200">
            Submit
        </button>

        <a href="dashboard.php"
            class="text-red-600 font-semibold py-2 px-4 hover:underline transition-all duration-200">
            Cancel
        </a>
    </div>
</form>


        <div class="mt-6 text-sm text-gray-600 text-center">
            For more info on leave policy, go to 
            <a href="#" class="text-red-600 underline font-medium">Time Off</a>.
        </div>
    </div>
</div>

<!-- Font Awesome (Optional if icons are needed) -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

<?php include '../includes/footer.php'; ?>

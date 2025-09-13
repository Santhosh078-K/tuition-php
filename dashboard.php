<?php
// File: tuition/dashboard.php
require_once('db/config.php');
include('templates/header.php');

// Ensure the user is logged in before they can access the dashboard
if (!isset($_SESSION['user_id'])) {
    header('Location: ' . BASE_URL . 'login.php');
    exit();
}

// Get the username for a personalized welcome message
$username = isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'User';

// --- Fetch Dashboard Statistics ---

// 1. Total Students
$total_students_result = mysqli_query($conn, "SELECT COUNT(*) as count FROM std_info");
$total_students = mysqli_fetch_assoc($total_students_result)['count'];

// 2. Total Income
$total_income_result = mysqli_query($conn, "SELECT SUM(pamt) as total_pamt FROM txn");
$total_income_row = mysqli_fetch_assoc($total_income_result);
$total_income = $total_income_row['total_pamt'] ?? 0; // Use null coalescing operator for safety

// 3. Pending Sessions (Example stat)
$pending_sessions_result = mysqli_query($conn, "SELECT COUNT(*) as count FROM schedule WHERE scstatus = 'Pending'");
$pending_sessions = mysqli_fetch_assoc($pending_sessions_result)['count'];

// 4. Unpaid Bills (Example stat)
$unpaid_bills_result = mysqli_query($conn, "SELECT COUNT(*) as count FROM bill WHERE complete = 0");
$unpaid_bills = mysqli_fetch_assoc($unpaid_bills_result)['count'];

// Data for Chart
$timezone_data = [];
$result_timezone = mysqli_query($conn, "SELECT tzone, COUNT(*) as count FROM std_info GROUP BY tzone");
while ($row_timezone = mysqli_fetch_assoc($result_timezone)) {
    // To make the chart cleaner, we can group smaller categories
    $tz_name = $row_timezone['tzone'] ?: 'Unknown';
    $timezone_data[$tz_name] = $row_timezone['count'];
}
?>

<?php include('templates/navbar.php'); // Include the top navigation bar 
?>

<div class="page-content">
    <div class="container-fluid">

        <!-- Welcome Header -->
        <div class="welcome-header mb-5 text-center">
            <h1 class="display-5 fw-bold">Welcome back, <?php echo $username; ?>!</h1>
            <p class="text-muted">Here is a summary of your tuition center's activity.</p>
        </div>

        <!-- 3D Statistic Cards -->
        <div class="row g-4">
            <div class="col-lg-3 col-md-6">
                <div class="stat-card-3d">
                    <div class="stat-card-content">
                        <div class="stat-icon icon-1"><i class="fas fa-dollar-sign"></i></div>
                        <div class="stat-text">
                            <h3 class="stat-title">Total Income</h3>
                            <p class="stat-value">₹<?php echo number_format($total_income); ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-card-3d">
                    <div class="stat-card-content">
                        <div class="stat-icon icon-2"><i class="fas fa-user-graduate"></i></div>
                        <div class="stat-text">
                            <h3 class="stat-title">Total Students</h3>
                            <p class="stat-value"><?php echo $total_students; ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-card-3d">
                    <div class="stat-card-content">
                        <div class="stat-icon icon-3"><i class="fas fa-clock"></i></div>
                        <div class="stat-text">
                            <h3 class="stat-title">Pending Sessions</h3>
                            <p class="stat-value"><?php echo $pending_sessions; ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-card-3d">
                    <div class="stat-card-content">
                        <div class="stat-icon icon-4"><i class="fas fa-file-invoice-dollar"></i></div>
                        <div class="stat-text">
                            <h3 class="stat-title">Unpaid Bills</h3>
                            <p class="stat-value"><?php echo $unpaid_bills; ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chart Section -->
        <div class="card shadow-lg border-0 mt-5">
            <div class="card-header bg-transparent border-0 pt-3">
                <h4 class="fw-bold">Student Distribution</h4>
            </div>
            <div class="card-body">
                <canvas id="timezonePieChart"></canvas>
            </div>
        </div>

    </div>
</div>

<script>
    // Pass PHP data to JavaScript for the chart
    const timezoneData = <?php echo json_encode($timezone_data); ?>;
</script>

<?php include('templates/footer.php'); ?>
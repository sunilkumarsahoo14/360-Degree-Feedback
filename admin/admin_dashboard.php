<?php
session_start();
if (!isset($_SESSION['email']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login_form.php");
    exit();
}
include("../dbconnect.php");

$email = $_SESSION['email'];
$query = "SELECT * FROM admin WHERE email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$admin = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard | 360° Feedback</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { display: flex; }
        .sidebar {
            width: 250px;
            background: #343a40;
            color: white;
            min-height: 100vh;
            padding-top: 20px;
            
        }
        .sidebar a {
            color: white;
            padding: 10px;
            display: block;
            text-decoration: none;
        }
        .sidebar a:hover, .sidebar a.active {
            background: #495057;
        }
        .content {
            flex-grow: 1;
            background: #f8f9fa;
        }
        .navbar-brand {
            font-weight: bold;
        }
        .topbar {
            padding: 1rem 2rem;
            background-color: #ffffff;
            border-bottom: 1px solid #dee2e6;
            display: flex;
            justify-content: space-between;
        }
        .card {
            border-radius: 1rem;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar px-2 py-4">
    <a href="admin_dashboard.php"><h4 class="text-center"><i class="bi bi-speedometer2 me-1"></i>Admin Panel</h4></a>    
    <a class="load-page" data-page="dashboard.php"><i class="bi bi-house-door me-1"></i>Dashboard</a>    
    <a class="load-page" data-page="faculty.php"><i class="bi bi-person-badge me-1"></i>Faculties</a>
    <a class="load-page" data-page="hod.php"><i class="bi bi-person-vcard me-1"></i>HODs</a>
    <a class="load-page" data-page="students.php"><i class="bi bi-people me-1"></i>Students</a>
    <a href="add_question.php"><i class="bi bi-plus-square me-1"></i>Add Question</a>
    <a href="view_questions.php" class="nav-link"><i class="bi bi-eye me-1"></i>View Questions</a>
    <a href="generate_report.php" data-page="generate_report.php"><i class="bi bi-bar-chart-line me-1"></i>Report</a>
    <a href="user_report.php" class="nav-link"><i class="bi bi-person-lines-fill me-1"></i>User Report</a>
    <a href="?profile=1"><i class="bi bi-person-circle me-1"></i>Profile</a>
    <a href="logout.php"><i class="bi bi-box-arrow-right me-1"></i>Logout</a>
</div>

<!-- Main Content -->
<div class="content w-100">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm sticky-top">
        <div class="container-fluid px-4">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <i class="bi bi-mortarboard-fill me-2 text-primary fs-4"></i>
                <span>The 360° Academic Feedback System</span>
                 <a href="?profile=1" class="btn btn-outline-primary btn-sm">
            <i class="bi bi-person-circle"></i> Profile
        </a>
            </a>
        </div>
    </nav>

    <!-- Topbar inside content -->
    <!-- <span class="topbar"> -->
        <h5>Welcome, <?= $admin['name']; ?> !</h5>
       


    <div id="main-content" class="p-4">
        <?php if (isset($_GET['profile'])): ?>
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-primary text-white rounded-top-4">
                    <h5 class="mb-0"><i class="bi bi-person-circle me-2"></i>Admin Profile</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Name:</label>
                        <div class="form-control-plaintext"><?= $admin['name']; ?></div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Email:</label>
                        <div class="form-control-plaintext"><?= $admin['email']; ?></div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Role:</label>
                        <div class="form-control-plaintext"><?= ucfirst($_SESSION['role']); ?></div>
                    </div>

                    <hr class="my-4">

                    <h6 class="text-primary mb-3">Change Password</h6>
                    <form action="update_admin.php" method="POST">
                        <div class="mb-3">
                            <label class="form-label">Current Password</label>
                            <input type="password" name="current_password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">New Password</label>
                            <input type="password" name="new_password" class="form-control" required>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success">Update Password</button>
                            <a href="logout.php" class="btn btn-outline-danger">Logout</a>
                        </div>
                    </form>
                </div>
            </div>
        <?php else: ?>
            <?php include("dashboard.php"); ?>
        <?php endif; ?>
    </div>
</div>

<script>
    document.querySelectorAll(".load-page").forEach(function (el) {
        el.addEventListener("click", function (e) {
            e.preventDefault();
            const page = this.getAttribute("data-page");
            fetch(page)
                .then(res => res.text())
                .then(html => {
                    document.getElementById("main-content").innerHTML = html;
                });
        });
    });
</script>

</body>
</html>

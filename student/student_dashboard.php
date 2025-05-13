<?php
session_start();
if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'student') {
    header("Location: ../login_form.php");
    exit();
}

include("../dbconnect.php");

$email = $_SESSION['email'];

$query = "SELECT s.*, d.dept_name, sec.section_name 
          FROM student s 
          LEFT JOIN department d ON s.dept_id = d.dept_id 
          LEFT JOIN section sec ON s.section_id = sec.section_id 
          WHERE s.email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background: #f8f9fa; font-family: 'Segoe UI', sans-serif; }
        .card { border-radius: 16px; box-shadow: 0 0.25rem 0.75rem rgba(0,0,0,0.05); }
        .card:hover { transform: translateY(-3px); }
        .profile-icon { font-size: 4rem; color: #6c757d; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand text-primary" href="#">Student Dashboard</a>
        <div class="d-flex align-items-center">
            <span class="me-3 text-muted"><i class="bi bi-person-circle me-1"></i> <?= htmlspecialchars($student['email']); ?></span>
            <a href="logout.php" class="btn btn-outline-danger btn-sm">Logout</a>
        </div>
    </div>
</nav>

<div class="container py-5">
    <div class="row justify-content-center mb-5">
        <div class="col-md-6">
            <div class="card text-center p-4">
                <div class="card-body">
                    <i class="bi bi-person-circle profile-icon mb-3"></i>
                    <h4 class="card-title"><?= htmlspecialchars($student['name']) ?></h4>
                    <p class="text-muted"><?= htmlspecialchars($student['email']) ?></p>
                    <p><strong>Department:</strong> <?= htmlspecialchars($student['dept_name']) ?> |
                       <strong>Section:</strong> <?= htmlspecialchars($student['section_name']) ?> |
                       <strong>Semester:</strong> <?= htmlspecialchars($student['semester_id']) ?>

                </div>
            </div>
        </div>
    </div>

    <!-- Feedback & Rating Cards -->
    <div class="row justify-content-center g-4">
        <div class="col-md-5">
            <div class="card text-center p-4">
                <div class="card-body">
                    <i class="bi bi-pencil-square display-5 text-primary mb-3"></i>
                    <h5 class="card-title">Give Feedback to Faculty</h5>
                    <a href="give_feedback.php" class="btn btn-primary mt-2">Start Feedback</a>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="card text-center p-4">
                <div class="card-body">
                    <i class="bi bi-bar-chart-fill display-5 text-success mb-3"></i>
                    <h5 class="card-title">See Your Rating</h5>
                    <a href="view_rating.php" class="btn btn-success mt-2">View Rating</a>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>

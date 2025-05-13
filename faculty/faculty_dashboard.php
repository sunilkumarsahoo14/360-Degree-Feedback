<?php
session_start();
if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'faculty') {
    header("Location: ../login_form.php");
    exit();
}

include("../dbconnect.php");

$email = $_SESSION['email'];

// Updated query: includes semester_name and section
$query = "SELECT f.*, d.dept_name, s.semester_name
          FROM faculty f 
          JOIN department d ON f.dept_id = d.dept_id 
          JOIN semester s ON f.semester_id = s.semester_id 
          WHERE f.email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$faculty = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Faculty Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
    <div class="container">
         <a class="navbar-brand text-primary" href="#">Faculty Dashboard</a>
            
        </a>
        <div class="d-flex align-items-center">
            <span class="me-3 text-muted">
                <i class="bi bi-person-circle me-1"></i> 
                <?php echo htmlspecialchars($faculty['email']); ?>
            </span>
            <a href="../student/logout.php" class="btn btn-outline-danger btn-sm">Logout</a>
        </div>
    </div>
</nav>

<!-- Main Container -->
<div class="container py-5">
    <!-- Profile Card -->
    <div class="row justify-content-center mb-5">
        <div class="col-md-6 col-sm-10">
            <div class="card p-4 text-center shadow">
                <i class="bi bi-person-badge-fill display-1 mb-3 text-primary"></i>
                <h4><?php echo htmlspecialchars($faculty['name']); ?></h4>
                <p><?php echo htmlspecialchars($faculty['email']); ?></p>
                <p>
                    <strong>Department:</strong> <?php echo $faculty['dept_name']; ?><br>
                    <strong>Semester:</strong> <?php echo $faculty['semester_name']; ?><br>
                    <!-- <strong>Section:</strong>  -->
                </p>
            </div>
        </div>
    </div>

    <!-- Action Cards -->
    <div class="row justify-content-center g-4">
        <!-- Give Feedback to Student -->
        <div class="col-md-4 col-sm-10">
            <div class="card p-4 text-center shadow h-100">
                <i class="bi bi-people-fill display-5 text-primary mb-3"></i>
                <h5>Give Feedback to Students</h5>
                <a href="give_feedback_student.php" class="btn btn-primary mt-2">Start Feedback</a>
            </div>
        </div>

        <!-- Give Feedback to HOD -->
        <div class="col-md-4 col-sm-10">
            <div class="card p-4 text-center shadow h-100">
                <i class="bi bi-person-workspace display-5 text-warning mb-3"></i>
                <h5>Give Feedback to HOD</h5>
                <a href="give_feedback_hod.php" class="btn btn-warning mt-2">Start Feedback</a>
            </div>
        </div>

        <!-- View Ratings -->
        <div class="col-md-4 col-sm-10">
            <div class="card p-4 text-center shadow h-100">
                <i class="bi bi-bar-chart-fill display-5 text-success mb-3"></i>
                <h5>View Ratings Given By hod</h5>
                <a href="view_rating_faculty_to_student.php" class="btn btn-success mt-2">View Feedback</a>
            </div>
        </div>

        <div class="col-md-4 col-sm-10">
            <div class="card p-4 text-center shadow h-100">
                <i class="bi bi-bar-chart-fill display-5 text-success mb-3"></i>
                <h5>View Ratings Given By hod</h5>
                <a href="view_rating.php" class="btn btn-success mt-2">View Feedback</a>
            </div>
        </div>
    </div>
</div>

</body>
</html>

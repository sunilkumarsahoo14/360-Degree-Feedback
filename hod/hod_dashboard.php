<?php
session_start();
if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'hod') {
    header("Location: ../login_form.php");
    exit();
}

include("../dbconnect.php");

$email = $_SESSION['email'];
$query = "SELECT h.*, d.dept_name 
          FROM hod h 
          JOIN department d ON h.dept_id = d.dept_id 
          WHERE h.email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$hod = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>HOD Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand text-primary" href="#">HOD Dashboard</a>
        <div class="d-flex align-items-center">
            <span class="me-3 text-muted"><i class="bi bi-person-circle me-1"></i> <?php echo htmlspecialchars($hod['email']); ?></span>
            <a href="../student/logout.php" class="btn btn-outline-danger btn-sm">Logout</a>
        </div>
    </div>
</nav>

<div class="container py-5">
    <div class="row justify-content-center mb-5">
        <div class="col-md-6 col-sm-10">
            <div class="card p-4 text-center shadow">
                <i class="bi bi-person-gear display-1 mb-3"></i>
                <h4><?php echo htmlspecialchars($hod['name']); ?></h4>
                <p><?php echo htmlspecialchars($hod['email']); ?></p>
                <p><strong>Department:</strong> <?php echo $hod['dept_name']; ?> |
                   
            </div>
        </div>
    </div>

    <div class="row justify-content-center g-4">
        <div class="col-md-5 col-sm-10">
            <div class="card p-4 text-center shadow">
                <i class="bi bi-clipboard-data display-5 text-primary mb-3"></i>
                <h5>Give Feedback to Faculties</h5>
                <a href="give_feedback.php" class="btn btn-primary mt-2">Start Feedback</a>
            </div>
        </div>
        <div class="col-md-5 col-sm-10">
            <div class="card p-4 text-center shadow">
                <i class="bi bi-bar-chart-fill display-5 text-success mb-3"></i>
                <h5>View Ratings</h5>
                <a href="view_rating.php" class="btn btn-success mt-2">View Ratings</a>
            </div>
        </div>
    </div>
</div>
</body>
</html>

<?php
session_start();
if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'faculty') {
    header("Location: ../login_form.php");
    exit();
}

include("../dbconnect.php");

$email = $_SESSION['email'];

// Get faculty department
$query = "SELECT * FROM faculty WHERE email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$faculty = $result->fetch_assoc();

$dept_id = $faculty['dept_id'];

// Get HOD from same department
$hodQuery = "SELECT * FROM hod WHERE dept_id = ?";
$stmt2 = $conn->prepare($hodQuery);
$stmt2->bind_param("i", $dept_id);
$stmt2->execute();
$hodResult = $stmt2->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Give Feedback to HOD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <a href="faculty_dashboard.php" class="btn btn-secondary mb-4">← Back to Dashboard</a>
    <h3 class="mb-4 text-center">HOD Available for Feedback</h3>

    <?php if ($hodResult->num_rows > 0): ?>
        <div class="row">
            <?php while ($hod = $hodResult->fetch_assoc()): ?>
                <div class="col-md-6 offset-md-3">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($hod['name']) ?></h5>
                            <p class="card-text"><strong>Email:</strong> <?= htmlspecialchars($hod['email']) ?></p>
                            <a href="faculty_to_hod_feedback.php?user_id=<?= $hod['user_id'] ?>&role=hod" class="btn btn-primary">
                                Give Feedback
                            </a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-warning text-center">No HOD found in your department.</div>
    <?php endif; ?>
</div>
</body>
</html>

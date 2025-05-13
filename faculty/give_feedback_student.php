<?php
session_start();
if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'faculty') {
    header("Location: ../login_form.php");
    exit();
}

include("../dbconnect.php");

$email = $_SESSION['email'];

// Get faculty's dept and section
$query = "SELECT * FROM faculty WHERE email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$faculty = $result->fetch_assoc();

$dept_id = $faculty['dept_id'];
$section_id = $faculty['section_id'];

// Fetch students of same dept and section
$studentQuery = "SELECT * FROM student WHERE dept_id = ? AND section_id = ?";
$stmt2 = $conn->prepare($studentQuery);
$stmt2->bind_param("ii", $dept_id, $section_id);
$stmt2->execute();
$studentResult = $stmt2->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Give Feedback to Students</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <a href="faculty_dashboard.php" class="btn btn-secondary mb-4">← Back to Dashboard</a>
    <h3 class="mb-4 text-center">Students Available for Feedback</h3>

    <?php if ($studentResult->num_rows > 0): ?>
        <div class="row row-cols-1 row-cols-md-2 g-4">
            <?php while ($student = $studentResult->fetch_assoc()): ?>
                <div class="col">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($student['name']) ?></h5>
                            <p class="card-text"><strong>Email:</strong> <?= htmlspecialchars($student['email']) ?></p>
                            <a href="faculty_to_student_feedback.php?user_id=<?= $student['user_id'] ?>&role=student" class="btn btn-primary">
                                Give Feedback
                            </a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-warning text-center">No students found in your department and section.</div>
    <?php endif; ?>
</div>
</body>
</html>

<?php
session_start();
if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'student') {
    header("Location: ../login_form.php");
    exit();
}

include("../dbconnect.php");

$email = $_SESSION['email'];

// Fetch student info (dept_id & section_id)
$studentQuery = "SELECT * FROM student WHERE email = ?";
$stmt = $conn->prepare($studentQuery);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();

$dept_id = $student['dept_id'];
$section_id = $student['section_id'];

// Get matching faculty from same department and section
$facultyQuery = "SELECT * FROM faculty WHERE dept_id = ? AND section_id = ?";
$stmt2 = $conn->prepare($facultyQuery);
$stmt2->bind_param("ii", $dept_id, $section_id);
$stmt2->execute();
$facultyResult = $stmt2->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Give Feedback</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <!-- 🔙 Back Button -->
    <a href="student_dashboard.php" class="btn btn-secondary mb-4">
        ← Back to Dashboard
    </a>

    <h3 class="mb-4 text-center">Faculty Available for Feedback</h3>

    <?php if ($facultyResult->num_rows > 0): ?>
        <div class="row row-cols-1 row-cols-md-2 g-4">
            <?php while ($faculty = $facultyResult->fetch_assoc()): ?>
                <div class="col">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($faculty['name']) ?></h5>
                            <p class="card-text"><strong>Email:</strong> <?= htmlspecialchars($faculty['email']) ?></p>
                            <a href="feedback_form.php?faculty_id=<?= $faculty['user_id'] ?>" class="btn btn-primary">
                                Give Feedback
                            </a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-warning text-center">No faculty found in your department and section.</div>
    <?php endif; ?>
</div>
</body>
</html>

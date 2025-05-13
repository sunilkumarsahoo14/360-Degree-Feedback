<?php
session_start();
include("../dbconnect.php");

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'hod') {
    header("Location: ../login_form.php");
    exit();
}

$hod_id = $_SESSION['user_id'];

// Get dept_id of HOD
$stmt = $conn->prepare("SELECT dept_id FROM hod WHERE user_id = ?");
$stmt->bind_param("i", $hod_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$dept_id = $row['dept_id'];

// Fetch faculty of same department
$stmt = $conn->prepare("SELECT user_id, name, email FROM faculty WHERE dept_id = ?");
$stmt->bind_param("i", $dept_id);
$stmt->execute();
$faculty = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Give Feedback to Faculty</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <!-- 🔙 Back Button -->
    <a href="hod_dashboard.php" class="btn btn-secondary mb-4">
        ← Back to Dashboard
    </a>

    <h3 class="mb-4 text-center">Faculty Available for Feedback</h3>

    <?php if ($faculty->num_rows > 0): ?>
        <div class="row row-cols-1 row-cols-md-2 g-4">
            <?php while ($row = $faculty->fetch_assoc()): ?>
                <div class="col">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($row['name']) ?></h5>
                            <p class="card-text"><strong>Email:</strong> <?= htmlspecialchars($row['email']) ?></p>
                            <a href="give_feedback_form.php?faculty_id=<?= $row['user_id'] ?>" class="btn btn-primary">
                                Give Feedback
                            </a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-warning text-center">No faculty found in your department.</div>
    <?php endif; ?>
</div>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

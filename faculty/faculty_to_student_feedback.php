<?php
session_start();
include("../dbconnect.php");

if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'faculty') {
    header("Location: ../login_form.php");
    exit();
}

$giver_id = $_SESSION['user_id'];
$giver_role = 'faculty';

$receiver_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;
$receiver_role = isset($_GET['role']) ? $_GET['role'] : '';

if ($receiver_id === 0 || $receiver_role !== 'student') {
    echo "<div class='alert alert-danger text-center'>Invalid student ID or role.</div>";
    exit();
}

// Check if feedback already submitted
$check = $conn->prepare("SELECT 1 FROM fedback WHERE giver_id = ? AND receiver_id = ? AND giver_role = ? AND receiver_role = ? LIMIT 1");
$check->bind_param("iiss", $giver_id, $receiver_id, $giver_role, $receiver_role);
$check->execute();
$alreadySubmitted = $check->get_result()->num_rows > 0;

// Get student name
$studentStmt = $conn->prepare("SELECT name FROM student WHERE user_id = ?");
$studentStmt->bind_param("i", $receiver_id);
$studentStmt->execute();
$studentResult = $studentStmt->get_result();
$student = $studentResult->fetch_assoc();

if (!$student) {
    echo "<div class='alert alert-danger text-center'>Student not found.</div>";
    exit();
}

// Get faculty-to-student questions
$feedback_type = 'faculty-to-student';
$questionStmt = $conn->prepare("SELECT * FROM questions WHERE role = ? AND feedback_type = ?");
$questionStmt->bind_param("ss", $giver_role, $feedback_type);
$questionStmt->execute();
$questions = $questionStmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Faculty to Student Feedback</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .star-rating input[type="radio"] { display: none; }
        .star-rating label {
            font-size: 1.5em;
            color: #ddd;
            cursor: pointer;
        }
        .star-rating input[type="radio"]:checked ~ label,
        .star-rating label:hover,
        .star-rating label:hover ~ label {
            color: gold;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h3 class="mb-4 text-center">Feedback for Student: <?= htmlspecialchars($student['name']) ?></h3>

    <?php if ($alreadySubmitted): ?>
        <div class="alert alert-warning text-center">You have already submitted feedback for this student.</div>
    <?php else: ?>
        <form action="../submit_feedback.php" method="POST">
            <input type="hidden" name="giver_id" value="<?= $giver_id ?>">
            <input type="hidden" name="giver_role" value="faculty">
            <input type="hidden" name="receiver_id" value="<?= $receiver_id ?>">
            <input type="hidden" name="receiver_role" value="student">

            <?php while ($q = $questions->fetch_assoc()): ?>
                <div class="mb-4">
                    <label class="form-label"><strong><?= htmlspecialchars($q['question_text']) ?></strong></label>
                    <div class="star-rating d-flex gap-2">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <input type="radio" id="q<?= $q['id'] ?>_<?= $i ?>" name="rating[<?= $q['id'] ?>]" value="<?= $i ?>" required>
                            <label for="q<?= $q['id'] ?>_<?= $i ?>">★</label>
                        <?php endfor; ?>
                    </div>
                </div>
            <?php endwhile; ?>

            <button type="submit" class="btn btn-success mt-3">Submit Feedback</button>
        </form>
    <?php endif; ?>
</div>
</body>
</html>

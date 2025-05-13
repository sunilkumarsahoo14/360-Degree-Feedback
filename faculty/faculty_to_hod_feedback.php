<?php
session_start();
include("../dbconnect.php");

if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'faculty') {
    header("Location: ../login_form.php");
    exit();
}

$giver_id = $_SESSION['user_id']; // Faculty's user_id
$giver_role = 'faculty';

// Fetch receiver (HOD) ID and role from URL
$receiver_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;
$receiver_role = isset($_GET['role']) ? $_GET['role'] : '';

// Validate receiver info
if ($receiver_id === 0 || $receiver_role !== 'hod') {
    echo "<div class='alert alert-danger text-center'>Invalid receiver information.</div>";
    exit();
}

// Check if feedback already submitted
$check = $conn->prepare("SELECT 1 FROM fedback WHERE giver_id = ? AND receiver_id = ? AND giver_role = ? AND receiver_role = ? LIMIT 1");
$check->bind_param("iiss", $giver_id, $receiver_id, $giver_role, $receiver_role);
$check->execute();
$alreadySubmitted = $check->get_result()->num_rows > 0;

// Fetch HOD name
$hodQuery = $conn->prepare("SELECT name FROM hod WHERE user_id = ?");
$hodQuery->bind_param("i", $receiver_id);
$hodQuery->execute();
$hodResult = $hodQuery->get_result();
$hod = $hodResult->fetch_assoc();

if (!$hod) {
    echo "<div class='alert alert-danger text-center'>HOD not found.</div>";
    exit();
}

// Fetch feedback questions
$questions = $conn->prepare("SELECT * FROM questions WHERE role = ? AND feedback_type = ?");
$feedback_type = 'faculty-to-hod';
$questions->bind_param("ss", $giver_role, $feedback_type);
$questions->execute();
$questionsResult = $questions->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Faculty to HOD Feedback</title>
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
    <h3 class="mb-4 text-center">Feedback for HOD: <?= htmlspecialchars($hod['name']) ?></h3>

    <?php if ($alreadySubmitted): ?>
        <div class="alert alert-warning text-center">You have already submitted feedback for this HOD.</div>
    <?php else: ?>
        <form action="../submit_feedback.php" method="POST">
            <input type="hidden" name="giver_id" value="<?= $giver_id ?>">
            <input type="hidden" name="giver_role" value="<?= $giver_role ?>">
            <input type="hidden" name="receiver_id" value="<?= $receiver_id ?>">
            <input type="hidden" name="receiver_role" value="<?= $receiver_role ?>">

            <?php while ($q = $questionsResult->fetch_assoc()): ?>
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

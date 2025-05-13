<?php
session_start();
include("../dbconnect.php");

if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'student') {
    header("Location: ../login_form.php");
    exit();
}

$student_email = $_SESSION['email'];
$faculty_id = isset($_GET['faculty_id']) ? intval($_GET['faculty_id']) : 0;

// Get student details
$studentQuery = $conn->prepare("SELECT user_id FROM student WHERE email = ?");
$studentQuery->bind_param("s", $student_email);
$studentQuery->execute();
$studentResult = $studentQuery->get_result();
$student = $studentResult->fetch_assoc();
$student_id = $student['user_id'];

// Check if feedback already submitted
$checkQuery = $conn->prepare("SELECT 1 FROM fedback WHERE giver_id = ? AND receiver_id = ? AND giver_role = 'student' AND receiver_role = 'faculty' LIMIT 1");
$checkQuery->bind_param("ii", $student_id, $faculty_id);
$checkQuery->execute();
$checkResult = $checkQuery->get_result();
$alreadySubmitted = $checkResult->num_rows > 0;

// Fetch faculty name
$faculty = $conn->query("SELECT name FROM faculty WHERE user_id = $faculty_id")->fetch_assoc();

// Fetch questions for student->faculty
$questions = $conn->query("SELECT * FROM questions WHERE role = 'student'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Give Feedback</title>
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
  <h3 class="mb-4 text-center">Feedback for <?= htmlspecialchars($faculty['name']) ?></h3>

  <?php if ($alreadySubmitted): ?>
    <div class="alert alert-warning text-center">You have already submitted feedback for this faculty. It cannot be edited.</div>
  <?php else: ?>
    <form action="../submit_feedback.php" method="POST">
      <input type="hidden" name="giver_id" value="<?= $student_id ?>">
      <input type="hidden" name="giver_role" value="student">
      <input type="hidden" name="receiver_id" value="<?= $faculty_id ?>">
      <input type="hidden" name="receiver_role" value="faculty">

      <?php while ($q = $questions->fetch_assoc()): ?>
        <div class="mb-4">
          <label class="form-label"><strong><?= $q['question_text'] ?></strong></label>
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

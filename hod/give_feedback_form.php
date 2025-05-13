<?php
session_start();
include("../dbconnect.php");

if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'hod') {
    header("Location: ../login_form.php");
    exit();
}

$hod_email = $_SESSION['email'];
$faculty_id = isset($_GET['faculty_id']) ? intval($_GET['faculty_id']) : 0;

// Get HOD user_id
$hodQuery = $conn->prepare("SELECT user_id FROM hod WHERE email = ?");
$hodQuery->bind_param("s", $hod_email);
$hodQuery->execute();
$hodResult = $hodQuery->get_result();
$hod = $hodResult->fetch_assoc();
$hod_id = $hod['user_id'];

// Check if feedback already submitted
$checkQuery = $conn->prepare("SELECT 1 FROM fedback WHERE giver_id = ? AND receiver_id = ? AND giver_role = 'hod' AND receiver_role = 'faculty' LIMIT 1");
$checkQuery->bind_param("ii", $hod_id, $faculty_id);
$checkQuery->execute();
$checkResult = $checkQuery->get_result();
$alreadySubmitted = $checkResult->num_rows > 0;

// Fetch faculty name
$faculty = $conn->query("SELECT name FROM faculty WHERE user_id = $faculty_id")->fetch_assoc();

// Fetch HOD→Faculty questions
$questions = $conn->query("SELECT * FROM questions WHERE role = 'hod'");
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
      <input type="hidden" name="giver_id" value="<?= $hod_id ?>">
      <input type="hidden" name="giver_role" value="hod">
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

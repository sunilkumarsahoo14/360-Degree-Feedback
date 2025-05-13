<?php
session_start();
include("../dbconnect.php");

// Only admin should access this page
if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login_form.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Feedback Question</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
  <h4>Add Feedback Question</h4>
  <p>Select the role of the feedback giver and the feedback type (who gives feedback to whom):</p>

  <form action="submit_question.php" method="POST">
    <div class="mb-3">
      <label class="form-label">Select Giver Role</label>
      <select name="role" class="form-select" required>
        <option value="" disabled selected>-- Select Role --</option>
        <option value="student">Student</option>
        <option value="faculty">Faculty</option>
        <option value="hod">HOD</option>
      </select>
    </div>

    <div class="mb-3">
      <label class="form-label">Select Feedback Type</label>
      <select name="feedback_type" class="form-select" required>
        <option value="" disabled selected>-- Select Feedback Type --</option>
        <option value="student-to-faculty">Student to Faculty</option>
        <option value="faculty-to-student">Faculty to Student</option>
        <option value="faculty-to-hod">Faculty to HOD</option>
        <option value="hod-to-faculty">HOD to Faculty</option>
      </select>
    </div>

    <div class="mb-3">
      <label class="form-label">Enter Question</label>
      <input type="text" name="question" class="form-control" required placeholder="Type your question here...">
    </div>

    <button type="submit" class="btn btn-primary">Add Question</button>
  </form>
</div>
</body>
</html>

<?php
include("../dbconnect.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $role = $_POST['role'];
    $feedback_type = $_POST['feedback_type'];
    $question = trim($_POST['question']);

    if (!empty($role) && !empty($feedback_type) && !empty($question)) {
        $stmt = $conn->prepare("INSERT INTO questions (question_text, role, feedback_type) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $question, $role, $feedback_type);

        if ($stmt->execute()) {
            echo "<script>alert('Question added successfully.'); window.location.href = 'admin_dashboard.php';</script>";
        } else {
            echo "<script>alert('Failed to add question.'); window.location.href = 'add_question.php';</script>";
        }
    } else {
        echo "<script>alert('Please fill all fields.'); window.location.href = 'add_question.php';</script>";
    }
} else {
    echo "Invalid request.";
}

<?php
include 'dbconnect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $question = $_POST['question_text'];
    $option1 = $_POST['option_1'];
    $option2 = $_POST['option_2'];
    $option3 = $_POST['option_3'];
    $option4 = $_POST['option_4'];
    $role = $_POST['role'];

    $stmt = $conn->prepare("INSERT INTO feedback_questions 
        (question_text, option_1, option_2, option_3, option_4, role) 
        VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $question, $option1, $option2, $option3, $option4, $role);

    if ($stmt->execute()) {
        echo "Question added successfully!";
    } else {
        echo "Error: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>

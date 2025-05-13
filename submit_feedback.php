<?php
include("dbconnect.php");
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $giver_id = intval($_POST['giver_id']);
    $receiver_id = intval($_POST['receiver_id']);
    $giver_role = $_POST['giver_role'];
    $receiver_role = $_POST['receiver_role'];
    $ratings = $_POST['rating'] ?? [];

    $insertQuery = "INSERT INTO fedback (giver_id, giver_role, receiver_id, receiver_role, question_id, rating) 
                    VALUES (?, ?, ?, ?, ?, ?)";
    $insertStmt = $conn->prepare($insertQuery);

    try {
        foreach ($ratings as $question_id => $rating) {
            $question_id = intval($question_id);
            $rating = intval($rating);
            $insertStmt->bind_param("isisii", $giver_id, $giver_role, $receiver_id, $receiver_role, $question_id, $rating);
            $insertStmt->execute();
        }

        // Redirect based on role
        switch ($giver_role) {
            case 'student':
                $redirect_url = './student/student_dashboard.php';
                break;
            case 'faculty':
                $redirect_url = './faculty/faculty_dashboard.php';
                break;
            case 'hod':
                $redirect_url = './hod/hod_dashboard.php';
                break;
            default:
                $redirect_url = '../login_form.php'; // In case of invalid role
                break;
        }

        // Ensure proper redirection after successful submission
        echo "<script>
            alert('Feedback submitted successfully!');
            window.location.href = '$redirect_url';
        </script>";

    } catch (mysqli_sql_exception $e) {
        if ($e->getCode() == 1062) {
            // Duplicate entry error
            echo "<script>
            alert('Feedback already submitted. You cannot submit again.');
            window.location.href = '" . $_SESSION['role'] . "/" . $_SESSION['role'] . "_dashboard.php';
        </script>";
        
        } else {
            // General error
            echo "<script>
                alert('An error occurred. Please try again.');
                window.location.href = 'give_feedback.php';
            </script>";
        }
    }
} else {
    echo "Invalid request method.";
}
?>

<?php
// Start the session
session_start();

// Include database connection
include("../dbconnect.php");

// Check if user is logged in
if (!isset($_SESSION['email']) || !in_array($_SESSION['role'], ['student', 'faculty', 'hod'])) {
    header("Location: ../login_form.php");
    exit();
}

// Fetch user's email and role from session
$user_email = $_SESSION['email'];
$user_role = $_SESSION['role'];

// Query to get user_id from the selected role table
$getIdQuery = "SELECT user_id, name FROM $user_role WHERE email = ?";
$stmt = $conn->prepare($getIdQuery);
$stmt->bind_param("s", $user_email);
$stmt->execute();
$user_result = $stmt->get_result();
$user_data = $user_result->fetch_assoc();

// If the user is found, proceed
if ($user_data) {
    $user_id = $user_data['user_id'];
    $user_name = $user_data['name'];

    // Query to get the average rating from the feedback table
    $rating_query = "SELECT AVG(f.rating) AS average_rating 
                     FROM fedback f 
                     WHERE f.receiver_id = ? AND f.receiver_role = ?";
    $rating_stmt = $conn->prepare($rating_query);
    $rating_stmt->bind_param("is", $user_id, $user_role);
    $rating_stmt->execute();
    $rating_result = $rating_stmt->get_result();
    $rating_data = $rating_result->fetch_assoc();

    // Query to get detailed feedback by question
    // $feedback_query = "SELECT q.question_text, AVG(f.rating) AS avg_rating
    //                    FROM fedback f
    //                    JOIN questions q ON f.question_id = q.id
    //                    WHERE f.receiver_id = ? AND f.receiver_role = ?
    //                    GROUP BY q.question_text";
    // $feedback_stmt = $conn->prepare($feedback_query);
    // $feedback_stmt->bind_param("is", $user_id, $user_role);
    // $feedback_stmt->execute();
    // $feedback_result = $feedback_stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Rating</title>
    <!-- Add Bootstrap CSS for styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h3>Your Feedback Rating</h3>

    <!-- Bootstrap Card for Displaying Rating -->
    <div class="card shadow-lg p-4">
        <div class="card-body">
            <h5 class="card-title">Average Rating for <strong><?php echo htmlspecialchars($user_name); ?></strong> (<?php echo htmlspecialchars($user_email); ?>)</h5>
            
            <!-- Rating display with rounded circle -->
            <div class="d-flex justify-content-center align-items-center">
                <div class="rounded-circle bg-warning text-white d-flex justify-content-center align-items-center" style="width: 80px; height: 80px; font-size: 30px;">
                    <?php 
                    // Display the average rating or a default message if no rating is available
                    echo $rating_data['average_rating'] !== null ? round($rating_data['average_rating'], 2) : "N/A"; 
                    ?>
                </div>
            </div>
            <p class="text-center mt-3" style="font-size: 20px;">
                <?php 
                echo $rating_data['average_rating'] !== null ? round($rating_data['average_rating'], 2) . " / 5 ⭐" : "No ratings yet.";
                ?>
            </p>

           
        </div>
    </div>
</div>

<!-- Add Bootstrap JS for interactivity -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
} else {
    // If the user is not found
    echo "<p class='text-danger'>User not found.</p>";
}
?>

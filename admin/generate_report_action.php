<?php
session_start();
include("../dbconnect.php");

if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login_form.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $role = $_POST['role'] ?? '';
    $email = $_POST['email'] ?? '';

    if (empty($role) || empty($email)) {
        echo "<p class='text-danger'>Role or Email not provided.</p>";
        exit();
    }

    // 1. Get user_id and name from respective role table
    $stmt = $conn->prepare("SELECT user_id, name FROM $role WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if (!$result || $result->num_rows === 0) {
        echo "<p class='text-danger'>User not found for this role.</p>";
        exit();
    }

    $user = $result->fetch_assoc();
    $receiver_id = $user['user_id'];
    $receiver_name = $user['name'];

    echo "<h4 class='mb-3'>Feedback Report for <strong>$receiver_name</strong> ($email)</h4>";

    // 2. Calculate average rating
    $stmt = $conn->prepare("SELECT AVG(rating) as avg_rating FROM fedback WHERE receiver_id = ? AND receiver_role = ?");
    $stmt->bind_param("is", $receiver_id, $role);
    $stmt->execute();
    $res = $stmt->get_result();
    $data = $res->fetch_assoc();

    if ($data && $data['avg_rating'] !== null) {
        $avg_rating = round($data['avg_rating'], 2);
        echo "<p><strong>Average Rating:</strong> $avg_rating / 5 ⭐</p>";

        // 3. Insert or Update average rating in average_ratings table
        $insertUpdate = $conn->prepare("
            INSERT INTO average_ratings (user_email, role, average_rating, calculated_on)
            VALUES (?, ?, ?, NOW())
            ON DUPLICATE KEY UPDATE average_rating = VALUES(average_rating), calculated_on = NOW()
        ");
        $insertUpdate->bind_param("ssd", $email, $role, $avg_rating);
        if ($insertUpdate->execute()) {
            echo "<p class='text-success'>Average rating updated successfully.</p>";
        } else {
            echo "<p class='text-danger'>Failed to update rating.</p>";
        }

        // 4. Show detailed feedback
        echo "<h5 class='mt-4'>Detailed Feedback:</h5>";
        $stmt = $conn->prepare("
            SELECT q.question_text, AVG(f.rating) as avg_rating
            FROM fedback f
            JOIN questions q ON f.question_id = q.id
            WHERE f.receiver_id = ? AND f.receiver_role = ?
            GROUP BY q.question_text
        ");
        $stmt->bind_param("is", $receiver_id, $role);
        $stmt->execute();
        $details = $stmt->get_result();

        if ($details->num_rows > 0) {
            echo "<table class='table table-bordered mt-3'>
                    <thead class='table-light'>
                        <tr>
                            <th>Question</th>
                            <th>Average Rating</th>
                        </tr>
                    </thead>
                    <tbody>";
            while ($row = $details->fetch_assoc()) {
                echo "<tr>
                        <td>" . htmlspecialchars($row['question_text']) . "</td>
                        <td>" . round($row['avg_rating'], 2) . " / 5</td>
                      </tr>";
            }
            echo "</tbody></table>";
        } else {
            echo "<p class='text-muted'>No question-wise feedback found.</p>";
        }

    } else {
        echo "<p class='text-warning'>No feedback data available for this user.</p>";
    }
} else {
    echo "<p class='text-danger'>Invalid request method.</p>";
}
?>

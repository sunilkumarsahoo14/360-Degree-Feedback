<?php
require_once "dbconnect.php"; // Ensure database connection

$error_message = ""; // Initialize error message

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    $user_type = $_POST["user"];

    global $conn;

    try {
        if ($user_type === "admin") {
            $table = "admin";
        } else {
            $error_message = "Invalid user type!";
        }

        if (empty($error_message)) {
            $qry = "SELECT * FROM $table WHERE email = ?";
            $stmt = $conn->prepare($qry);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();

            if ($user) {
                if ($password === $user["password"]) { 
                    header("Location: admin/admin_dashboard.php"); // Redirect only if login is successful
                    exit();
                } else {
                    $error_message = "Incorrect Credentials! Try Again!";
                }
            } else {
                $error_message = "User not found!";
            }
            $stmt->close();
        }
    } catch (Exception $e) {
        $error_message = "Something went wrong! Please try again.";
    } finally {
        $conn->close();
    }
}

// Send error message back to login page
if (!empty($error_message)) {
    header("Location: login_form.php?error=" . urlencode($error_message));
    exit();
}
?>

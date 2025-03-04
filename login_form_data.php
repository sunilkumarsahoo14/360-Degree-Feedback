<?php
require_once "dbconnect.php"; // Ensure this file correctly connects to your database

if (isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["user"])) {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    $user_type = $_POST["user"]; // Fetch user type from dropdown

    global $conn;

    try {
        // Determine the table based on user type
        $table = "";
        switch ($user_type) {
            case "admin":
                $table = "admin";
                break;
            case "student":
                $table = "students";
                break;
            case "faculty":
                $table = "faculty";
                break;
            case "hod":
                $table = "hod";
                break;
            default:
                echo "<script>alert('Invalid user type selected!'); window.location.href='index.php';</script>";
                exit();
        }

        // Fetch user data from the selected table
        $qry = "SELECT * FROM $table WHERE email = ?";
        $stmt = $conn->prepare($qry);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user) {
            $saved_password = $user["password"];

            // Verify password (use password_verify() if passwords are hashed)
            if ($password === $saved_password) { 
                // Redirect user based on their type
                switch ($user_type) {
                    case "admin":
                        header("Location: admin/admin_dashboard.php");
                        break;
                    case "student":
                        header("Location: student/student_dashboard.php");
                        break;
                    case "faculty":
                        header("Location: faculty/faculty_dashboard.php");
                        break;
                    case "hod":
                        header("Location: hod/hod_dashboard.php");
                        break;
                }
                exit();
            } else {
                echo "<script>alert('Incorrect password!'); window.location.href='index.php';</script>";
            }
        } else {
            echo "<script>alert('User not found!'); window.location.href='index.php';</script>";
        }
    } catch (Exception $e) {
        die("Error: " . $e->getMessage());
    } finally {
        $stmt->close();
        $conn->close();
    }
} else {
    echo "<script>alert('Please fill in all fields.'); window.location.href='index.php';</script>";
}
?>

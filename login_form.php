<?php
session_start();
include("dbconnect.php");

if (isset($_SESSION['user_id'])) {
    header("Location: " . $_SESSION['role'] . "/" . $_SESSION['role'] . "_dashboard.php");
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Validate role
    $valid_roles = ['student', 'faculty', 'hod', 'admin'];
    if (!in_array($role, $valid_roles)) {
        echo "<script>alert('Invalid role selected.'); window.location.href='login_form.php';</script>";
        exit();
    }

    // Fetch user by email
    $query = "SELECT * FROM $role WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Use this if passwords are hashed (recommended)
        // if (password_verify($password, $user['password'])) {

        // Use this if passwords are in plain text (for testing only)
        if ($password === $user['password']) {
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $role;
            $_SESSION['user_id'] = $user['user_id'];

            header("Location: {$role}/{$role}_dashboard.php");
            exit();
        } else {
            echo "<script>alert('Incorrect password!'); window.location.href='login_form.php';</script>";
        }
    } else {
        echo "<script>alert('User not found!'); window.location.href='login_form.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login | 360° Feedback</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow-lg">
                    <div class="card-header text-center bg-primary text-white">
                        <h4>Login Panel</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email address</label>
                                <input type="email" class="form-control" name="email" id="email" required>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" name="password" id="password" required>
                            </div>

                            <div class="mb-3">
                                <label for="role" class="form-label">Login as</label>
                                <select name="role" class="form-select" id="role" required>
                                    <option value="">Select Role</option>
                                    <option value="student">Student</option>
                                    <option value="faculty">Faculty</option>
                                    <option value="hod">HOD</option>
                                    <option value="admin">Admin</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Login</button>
                        </form>
                    </div>
                    <div class="card-footer text-muted text-center">
                        360° Feedback System
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

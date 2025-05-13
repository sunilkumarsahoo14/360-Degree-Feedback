<?php
include '../dbconnect.php';

// Validation functions
function isValidEmail($email) {
    return (strlen($email) >= 6 && str_ends_with($email, '@faculty.com'));
}

function isValidMobile($mobile) {
    return preg_match('/^[6-9]\d{9}$/', $mobile);
}

function isValidPassword($password) {
    return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/', $password);
}

// Add Faculty
if (isset($_POST['add_faculty'])) {
    $name     = $_POST['name'];
    $email    = $_POST['email'];
    $phone    = $_POST['mobile'];
    $password = $_POST['password'];
    $dept_id  = $_POST['dept'];
    $section  = $_POST['sec'];
    $semester = $_POST['sem'];

    // Validations
    if (!isValidEmail($email)) {
        echo "<script>alert('Invalid Email. Must be at least 6 characters and end with @faculty.com'); history.back();</script>";
        exit();
    }

    if (!isValidMobile($phone)) {
        echo "<script>alert('Invalid Mobile Number. Must be 10 digits starting with 6/7/8/9'); history.back();</script>";
        exit();
    }

    if (!isValidPassword($password)) {
        echo "<script>alert('Password must contain at least 1 uppercase, 1 lowercase, 1 number, 1 special character and be at least 8 characters long'); history.back();</script>";
        exit();
    }

    // Insert the faculty data (No password hashing)
    $stmt = $conn->prepare("INSERT INTO faculty (name, email, mobile, password, dept_id, section_id, semester_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssiii", $name, $email, $phone, $password, $dept_id, $section, $semester);

    if ($stmt->execute()) {
        echo "<script>alert('Faculty added successfully'); window.location.href='admin_dashboard.php?section=faculty.php';</script>";
    } else {
        echo "<script>alert('Error while adding faculty'); history.back();</script>";
    }
}

// Update Faculty
if (isset($_POST['update_faculty'])) {
    $user_id  = $_POST['user_id'];
    $name     = $_POST['name'];
    $email    = $_POST['email'];
    $phone    = $_POST['phone'];
    $dept_id  = $_POST['dept_id'];
    $section  = $_POST['section_id'];
    $semester = $_POST['semester_id'];

    // Validations
    if (!isValidEmail($email)) {
        echo "<script>alert('Invalid Email. Must be at least 6 characters and end with @faculty.com'); history.back();</script>";
        exit();
    }

    if (!isValidMobile($phone)) {
        echo "<script>alert('Invalid Mobile Number. Must be 10 digits starting with 6/7/8/9'); history.back();</script>";
        exit();
    }

    // If password is provided, update it
    if (!empty($_POST['password'])) {
        $password = $_POST['password'];
        $stmt = $conn->prepare("UPDATE faculty SET name=?, email=?, mobile=?, password=?, dept_id=?, section_id=?, semester_id=? WHERE user_id=?");
        $stmt->bind_param("ssssiiiii", $name, $email, $phone, $password, $dept_id, $section, $semester, $user_id);
    } else {
        // If password is not provided, do not update the password field
        $stmt = $conn->prepare("UPDATE faculty SET name=?, email=?, mobile=?, dept_id=?, section_id=?, semester_id=? WHERE user_id=?");
        $stmt->bind_param("ssssiii", $name, $email, $phone, $dept_id, $section, $semester, $user_id);
    }

    if ($stmt->execute()) {
        echo "<script>alert('Faculty updated successfully'); window.location.href='admin_dashboard.php?section=faculty.php';</script>";
    } else {
        echo "<script>alert('Update failed'); history.back();</script>";
    }
}

// Delete Faculty
if (isset($_GET['delete_faculty'])) {
    $id = $_GET['delete_faculty'];
    $conn->query("DELETE FROM faculty WHERE user_id = $id");
    header("Location: admin_dashboard.php?section=faculty.php");
}
?>

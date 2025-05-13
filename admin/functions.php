<?php
include '../dbconnect.php';

// Validation functions
function isValidEmail($email) {
    return (strlen($email) >= 6 && str_ends_with($email, '@student.com'));
}

function isValidMobile($mobile) {
    return preg_match('/^[6-9]\d{9}$/', $mobile);
}

function isValidPassword($password) {
    return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/', $password);
}

// ADD STUDENT
if (isset($_POST['add_student'])) {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $mobile = $_POST['phone'];
  $password = $_POST['password'];
  $dept_id = $_POST['dept'];
  $section_id = $_POST['sec'];
  $semester_id = $_POST['sem'];

  // Validations
  if (!isValidEmail($email)) {
    echo "<script>alert('Invalid Email. Must be at least 6 characters and end with @student.com'); history.back();</script>";
    exit();
  }

  if (!isValidMobile($mobile)) {
    echo "<script>alert('Invalid Mobile Number. Must be 10 digits starting with 6/7/8/9'); history.back();</script>";
    exit();
  }

  if (!isValidPassword($password)) {
    echo "<script>alert('Password must contain at least 1 uppercase, 1 lowercase, 1 number, 1 special character and be at least 8 characters long'); history.back();</script>";
    exit();
  }

  // Insert the student data without hashing the password
  $stmt = $conn->prepare("INSERT INTO student (name, email, mobile, password, dept_id, section_id, semester_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
  $stmt->bind_param("ssssiii", $name, $email, $mobile, $password, $dept_id, $section_id, $semester_id);

  if ($stmt->execute()) {
    header("Location: admin_dashboard.php?section=students.php");
    exit;
  } else {
    echo "<script>alert('Failed to add student'); history.back();</script>";
  }
}

// UPDATE STUDENT
if (isset($_POST['update_student'])) {
  $user_id = $_POST['user_id'];
  $name = $_POST['name'];
  $email = $_POST['email'];
  $mobile = $_POST['phone'];
  $dept_id = $_POST['dept_id'];
  $section_id = $_POST['section_id'];
  $semester_id = $_POST['semester_id'];

  // Validations
  if (!isValidEmail($email)) {
    echo "<script>alert('Invalid Email. Must be at least 6 characters and end with @faculty.com'); history.back();</script>";
    exit();
  }

  if (!isValidMobile($mobile)) {
    echo "<script>alert('Invalid Mobile Number. Must be 10 digits starting with 6/7/8/9'); history.back();</script>";
    exit();
  }

  // If password is provided, validate it
  if (!empty($_POST['password']) && !isValidPassword($_POST['password'])) {
    echo "<script>alert('Password must contain at least 1 uppercase, 1 lowercase, 1 number, 1 special character and be at least 8 characters long'); history.back();</script>";
    exit();
  }

  $password = $_POST['password'];

  // Update student data without hashing the password
  if (!empty($password)) {
    $stmt = $conn->prepare("UPDATE student SET name=?, email=?, mobile=?, password=?, dept_id=?, section_id=?, semester_id=? WHERE user_id=?");
    $stmt->bind_param("ssssiiiii", $name, $email, $mobile, $password, $dept_id, $section_id, $semester_id, $user_id);
  } else {
    $stmt = $conn->prepare("UPDATE student SET name=?, email=?, mobile=?, dept_id=?, section_id=?, semester_id=? WHERE user_id=?");
    $stmt->bind_param("ssssiii", $name, $email, $mobile, $dept_id, $section_id, $semester_id, $user_id);
  }

  if ($stmt->execute()) {
    header("Location: admin_dashboard.php?section=students.php");
    exit;
  } else {
    echo "<script>alert('Update failed'); history.back();</script>";
  }
}

// DELETE STUDENT
if (isset($_GET['delete_student'])) {
  $id = $_GET['delete_student'];
  if ($conn->query("DELETE FROM student WHERE user_id = $id")) {
    header("Location: admin_dashboard.php?section=students.php");
    exit;
  } else {
    echo "<script>alert('Failed to delete student'); history.back();</script>";
  }
}
?>

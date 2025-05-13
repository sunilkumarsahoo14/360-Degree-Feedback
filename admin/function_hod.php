<?php
include '../dbconnect.php';

// Validation functions
function isValidEmail($email) {
    return (strlen($email) >= 6 && str_ends_with($email, '@hod.com'));
}

function isValidMobile($mobile) {
    return preg_match('/^[6-9]\d{9}$/', $mobile);
}

function isValidPassword($password) {
    return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/', $password);
}

// ADD HOD
if (isset($_POST['add_hod'])) {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $phone = $_POST['mobile'];
  $password = $_POST['password'];
  $dept_id = $_POST['dept'];

  // Validation
  if (!isValidEmail($email)) {
    echo "<script>alert('Invalid Email. Must be at least 6 characters and end with @hod.com'); history.back();</script>";
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

  // Hash the password
  $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

  $stmt = $conn->prepare("INSERT INTO hod (name, email, mobile, password, dept_id) VALUES (?, ?, ?, ?, ?)");
  $stmt->bind_param("ssssi", $name, $email, $phone, $hashedPassword, $dept_id);

  if ($stmt->execute()) {
    echo "<script>alert('HOD added successfully'); window.location.href='admin_dashboard.php?section=hod.php';</script>";
  } else {
    echo "<script>alert('Failed to add HOD'); history.back();</script>";
  }
}

// UPDATE HOD
if (isset($_POST['update_hod'])) {
  $id = $_POST['user_id'];
  $name = $_POST['name'];
  $email = $_POST['email'];
  $phone = $_POST['phone'];
  $dept_id = $_POST['dept_id'];

  // Validation
  if (!isValidEmail($email)) {
    echo "<script>alert('Invalid Email. Must be at least 6 characters and end with @hod.com'); history.back();</script>";
    exit();
  }

  if (!isValidMobile($phone)) {
    echo "<script>alert('Invalid Mobile Number. Must be 10 digits starting with 6/7/8/9'); history.back();</script>";
    exit();
  }

  if (!empty($_POST['password']) && !isValidPassword($_POST['password'])) {
    echo "<script>alert('Password must contain at least 1 uppercase, 1 lowercase, 1 number, 1 special character and be at least 8 characters long'); history.back();</script>";
    exit();
  }

  // If password is provided, hash it
  if (!empty($_POST['password'])) {
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $stmt = $conn->prepare("UPDATE hod SET name=?, email=?, mobile=?, password=?, dept_id=? WHERE user_id=?");
    $stmt->bind_param("ssssii", $name, $email, $phone, $password, $dept_id, $id);
  } else {
    // If no password is provided, don't update it
    $stmt = $conn->prepare("UPDATE hod SET name=?, email=?, mobile=?, dept_id=? WHERE user_id=?");
    $stmt->bind_param("ssssi", $name, $email, $phone, $dept_id, $id);
  }

  if ($stmt->execute()) {
    echo "<script>alert('HOD updated successfully'); window.location.href='admin_dashboard.php?section=hod.php';</script>";
  } else {
    echo "<script>alert('Update failed'); history.back();</script>";
  }
}

// DELETE HOD
if (isset($_GET['delete_hod'])) {
  $id = $_GET['delete_hod'];
  if ($conn->query("DELETE FROM hod WHERE user_id = $id")) {
    echo "<script>alert('HOD deleted successfully'); window.location.href='admin_dashboard.php?section=hod.php';</script>";
  } else {
    echo "<script>alert('Failed to delete HOD'); history.back();</script>";
  }
}
?>

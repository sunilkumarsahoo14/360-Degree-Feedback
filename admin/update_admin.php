<?php
session_start();
include("../dbconnect.php");

if (!isset($_SESSION['email']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login_form.php");
    exit();
}

$email = $_SESSION['email'];
$current_password = $_POST['current_password'];
$new_password = $_POST['new_password'];

$stmt = $conn->prepare("SELECT * FROM admin WHERE email = ? AND password = ?");
$stmt->bind_param("ss", $email, $current_password);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $update = $conn->prepare("UPDATE admin SET password = ? WHERE email = ?");
    $update->bind_param("ss", $new_password, $email);
    $update->execute();
    echo "<script>alert('Password updated successfully'); window.location.href='admin_dashboard.php?profile=1';</script>";
} else {
    echo "<script>alert('Current password is incorrect'); window.location.href='admin_dashboard.php?profile=1';</script>";
}

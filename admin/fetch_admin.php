<?php
session_start();
include '../dbconnect.php'; 

// Assuming admin is logged in, use session or a static ID (replace with session later)
$admin_id = 1; // Change this to `$_SESSION['admin_id']` when session is available

$sql = "SELECT * FROM admin WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $admin_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $admin = $result->fetch_assoc();
    echo json_encode($admin);
} else {
    echo json_encode(["error" => "Admin not found"]);
}

$stmt->close();
$conn->close();
?>

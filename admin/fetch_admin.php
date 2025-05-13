<?php
session_start();
include '../dbconnect.php';

$response = [];

if (!isset($_SESSION['user_id'])) {
    $response = ["success" => false, "message" => "Admin not logged in."];
} else {
    $admin_id = $_SESSION['user_id'];

    $query = "SELECT user_id, name, phone, email FROM admin WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $admin_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($admin = $result->fetch_assoc()) {
        $response = ["success" => true, ...$admin];
    } else {
        $response = ["success" => false, "message" => "Admin data not found."];
    }

    $stmt->close();
}

header('Content-Type: application/json');
echo json_encode($response);
?>

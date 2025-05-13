<?php
include("../dbconnect.php");

if (isset($_GET['role'])) {
    $role = $_GET['role'];
    $emails = [];

    $stmt = $conn->prepare("SELECT email FROM $role");
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $emails[] = $row['email'];
    }

    echo json_encode($emails);
}
?>

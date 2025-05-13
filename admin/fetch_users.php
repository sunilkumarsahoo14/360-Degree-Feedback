<?php
require_once "dbconnect.php";

$role = $_POST['role'];

$allowed_roles = ['student', 'faculty', 'hod'];
if (!in_array($role, $allowed_roles)) {
    echo json_encode([]);
    exit;
}

$q = "SELECT user_id, email FROM $role";
$res = mysqli_query($conn, $q);

$data = [];
if ($res && mysqli_num_rows($res) > 0) {
    while ($row = mysqli_fetch_assoc($res)) {
        $data[] = $row;
    }
}

echo json_encode($data);
?>

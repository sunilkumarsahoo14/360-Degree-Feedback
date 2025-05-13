<?php
require_once "db_connection.php";

if (isset($_POST['role'])) {
    $role = $_POST['role'];

    switch ($role) {
        case 'student':
            $table = "Students";
            break;
        case 'faculty':
            $table = "Faculty";
            break;
        case 'hod':
            $table = "HOD";
            break;
        default:
            echo "<option value=''>Invalid Role</option>";
            exit;
    }

    $query = "SELECT user_id, name FROM $table";
    $result = $conn->query($query);

    echo "<option value=''>--Select User--</option>";
    while ($row = $result->fetch_assoc()) {
        echo "<option value='{$row['user_id']}'>{$row['name']} (ID: {$row['user_id']})</option>";
    }
}
?>

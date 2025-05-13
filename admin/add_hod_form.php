<?php
include('../dbconnect.php');
$edit = false;
$hod = ['hod_id' => '', 'name' => '', 'email' => '', 'password' => '', 'mobile' => '', 'dept' => ''];

if (isset($_GET['edit'])) {
    $edit = true;
    $stmt = $conn->prepare("SELECT * FROM hod WHERE hod_id = ?");
    $stmt->bind_param("s", $_GET['edit']);
    $stmt->execute();
    $result = $stmt->get_result();
    $hod = $result->fetch_assoc();
}

$departments = $conn->query("SELECT * FROM department");
?>

<!DOCTYPE html>
<html>
<head>
    <title><?= $edit ? 'Edit' : 'Add' ?> HOD</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body>
<div class="container mt-4">
    <h2 class="mb-4"><?= $edit ? 'Edit' : 'Add' ?> HOD</h2>
    <form method="POST" action="function_hod.php">
        <input type="hidden" name="<?= $edit ? 'update_hod' : 'add_hod' ?>" value="1">
        
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" value="<?= $hod['name'] ?>" required>
        </div>
        
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="<?= $hod['email'] ?>" required>
        </div>
        
        <div class="mb-3">
            <label>Password</label>
            <div class="input-group">
                <input type="password" name="password" id="password" class="form-control" value="<?= $hod['password'] ?>" required>
                <span class="input-group-text" onclick="togglePassword()" style="cursor: pointer;">
                    <i id="eyeIcon" class="bi bi-eye-fill"></i>
                </span>
            </div>
        </div>
        
        <div class="mb-3">
            <label>Mobile</label>
            <input type="text" name="mobile" class="form-control" value="<?= $hod['mobile'] ?>" required>
        </div>
        
        <div class="mb-3">
            <label>Department</label>
            <select name="dept" class="form-control" required>
                <option value="">-- Select Department --</option>
                <?php while($row = $departments->fetch_assoc()): ?>
                    <option value="<?= $row['dept_id'] ?>" <?= $hod['dept'] == $row['dept_id'] ? 'selected' : '' ?>><?= $row['dept_name'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        
        <button type="submit" class="btn btn-success"><?= $edit ? 'Update' : 'Add' ?> HOD</button>
        <a href="hod.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<script>
function togglePassword() {
    const passwordInput = document.getElementById("password");
    const eyeIcon = document.getElementById("eyeIcon");
    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        eyeIcon.classList.remove("bi-eye-fill");
        eyeIcon.classList.add("bi-eye-slash-fill");
    } else {
        passwordInput.type = "password";
        eyeIcon.classList.remove("bi-eye-slash-fill");
        eyeIcon.classList.add("bi-eye-fill");
    }
}
</script>
</body>
</html>

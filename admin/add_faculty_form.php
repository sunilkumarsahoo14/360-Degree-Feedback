<?php
include('../dbconnect.php');

$deptResult = $conn->query("SELECT * FROM department");
$secResult = $conn->query("SELECT * FROM section");
$semResult = $conn->query("SELECT * FROM semester");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Faculty</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-2">
    <h2 class="mb-2">Add New Faculty</h2>
    <form action="function_faculty.php" method="POST" class="bg-white p-4 rounded shadow-sm">
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Mobile</label>
            <input type="text" name="mobile" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Department</label>
            <select name="dept" class="form-select" required>
                <option value="">-- Select Department --</option>
                <?php while ($row = $deptResult->fetch_assoc()): ?>
                    <option value="<?= $row['dept_id'] ?>"><?= $row['dept_name'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Section</label>
            <select name="sec" class="form-select" required>
                <option value="">-- Select Section --</option>
                <?php while ($row = $secResult->fetch_assoc()): ?>
                    <option value="<?= $row['section_id'] ?>"><?= $row['section_name'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Semester</label>
            <select name="sem" class="form-select" required>
                <option value="">-- Select Semester --</option>
                <?php while ($row = $semResult->fetch_assoc()): ?>
                    <option value="<?= $row['semester_id'] ?>"><?= $row['semester_name'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <button type="submit" name="add_faculty" class="btn btn-success">Add Faculty</button>
    </form>
</div>
</body>
</html>

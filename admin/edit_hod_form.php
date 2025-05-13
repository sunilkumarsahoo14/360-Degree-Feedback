<?php
include '../dbconnect.php';

$id = $_GET['id'];
$data = $conn->query("SELECT * FROM hod WHERE user_id = $id");
$row = $data->fetch_assoc();

// Get department and semester lists
$departments = $conn->query("SELECT * FROM department");
$semesters = $conn->query("SELECT * FROM semester");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit HOD</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
  <div class="bg-white p-5 rounded shadow">
    <h3 class="mb-4 text-primary">Edit HOD</h3>
    <form action="function_hod.php" method="POST">
      <input type="hidden" name="user_id" value="<?= $row['user_id'] ?>">

      <div class="row">
        <div class="col-md-6 mb-3">
          <label class="form-label">HOD Name</label>
          <input type="text" name="name" value="<?= $row['name'] ?>" class="form-control" required>
        </div>

        <div class="col-md-6 mb-3">
          <label class="form-label">Email</label>
          <input type="email" name="email" value="<?= $row['email'] ?>" class="form-control" required>
        </div>

        <div class="col-md-6 mb-3">
          <label class="form-label">Phone</label>
          <input type="text" name="phone" value="<?= $row['mobile'] ?>" class="form-control" required>
        </div>

        <div class="col-md-6 mb-3">
          <label class="form-label">Password <small class="text-muted">(Leave blank to keep old)</small></label>
          <input type="password" name="password" class="form-control">
        </div>

        <div class="col-md-6 mb-3">
          <label class="form-label">Department</label>
          <select name="dept_id" class="form-select" required>
            <option value="">Select Department</option>
            <?php while ($d = $departments->fetch_assoc()): 
              $selected = ($d['dept_id'] == $row['dept_id']) ? 'selected' : '';
              echo "<option value='{$d['dept_id']}' $selected>{$d['dept_name']}</option>";
            endwhile; ?>
          </select>
        </div>

        <div class="col-md-6 mb-3">
          <label class="form-label">Semester</label>
          <select name="semester" class="form-select" required>
            <option value="">Select Semester</option>
            <?php while ($s = $semesters->fetch_assoc()): 
              $selected = ($s['semester_id'] == $row['semester']) ? 'selected' : '';
              echo "<option value='{$s['semester_id']}' $selected>{$s['semester_name']}</option>";
            endwhile; ?>
          </select>
        </div>
      </div>

      <div class="mt-4">
        <button type="submit" name="update_hod" class="btn btn-success">Update HOD</button>
        <a href="admin_dashboard.php?section=hod.php" class="btn btn-secondary ms-2">Cancel</a>
      </div>
    </form>
  </div>
</div>
</body>
</html>

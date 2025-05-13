<?php
include '../dbconnect.php';

if (isset($_GET['id'])) {
  $id = $_GET['id'];
  $res = $conn->query("SELECT * FROM faculty WHERE user_id = $id");
  $faculty = $res->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Faculty</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
  <div class="bg-white p-5 rounded shadow">
    <h3 class="mb-4 text-primary">Edit Faculty</h3>
    <form action="function_faculty.php" method="POST">
      <input type="hidden" name="user_id" value="<?= $faculty['user_id'] ?>">

      <div class="row">
        <div class="col-md-6 mb-3">
          <label class="form-label">Name</label>
          <input type="text" name="name" class="form-control" value="<?= $faculty['name'] ?>" required>
        </div>

        <div class="col-md-6 mb-3">
          <label class="form-label">Email</label>
          <input type="email" name="email" class="form-control" value="<?= $faculty['email'] ?>" required>
        </div>

        <div class="col-md-6 mb-3">
          <label class="form-label">Phone</label>
          <input type="text" name="phone" class="form-control" value="<?= $faculty['mobile'] ?>" required>
        </div>

        <div class="col-md-6 mb-3">
          <label class="form-label">Department</label>
          <select name="dept_id" class="form-select" required>
            <?php
            $dres = $conn->query("SELECT * FROM department");
            while ($d = $dres->fetch_assoc()) {
              $selected = ($d['dept_id'] == $faculty['dept_id']) ? 'selected' : '';
              echo "<option value='{$d['dept_id']}' $selected>{$d['dept_name']}</option>";
            }
            ?>
          </select>
        </div>

        <div class="col-md-6 mb-3">
          <label class="form-label">Semester</label>
          <select name="semester_id" class="form-select" required>
            <?php
            $sres = $conn->query("SELECT * FROM semester");
            while ($s = $sres->fetch_assoc()) {
              $selected = ($s['semester_id'] == $faculty['semester_id']) ? 'selected' : '';
              echo "<option value='{$s['semester_id']}' $selected>{$s['semester_name']}</option>";
            }
            ?>
          </select>
        </div>

        <div class="col-md-6 mb-3">
          <label class="form-label">Section</label>
          <select name="section_id" class="form-select" required>
            <?php
            $secres = $conn->query("SELECT * FROM section");
            while ($sec = $secres->fetch_assoc()) {
              $selected = ($sec['section_id'] == $faculty['section_id']) ? 'selected' : '';
              echo "<option value='{$sec['section_id']}' $selected>{$sec['section_name']}</option>";
            }
            ?>
          </select>
        </div>
      </div>

      <div class="mt-4">
        <button type="submit" name="update_faculty" class="btn btn-primary">Update Faculty</button>
        <a href="admin_dashboard.php?section=faculty.php" class="btn btn-secondary ms-2">Cancel</a>
      </div>
    </form>
  </div>
</div>
</body>
</html>

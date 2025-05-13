<?php
include '../dbconnect.php';
$id = $_GET['id'];
$q = $conn->query("SELECT * FROM student WHERE user_id=$id");
$data = $q->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit HOD</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<div class="container mt-4">
  <h3>Edit Student</h3>
  <form action="functions.php" method="POST">
    <input type="hidden" name="user_id" value="<?= $data['user_id'] ?>">
    
    <div class="row">
      <div class="col-md-6 mb-3">
        <label>Name</label>
        <input type="text" name="name" class="form-control" value="<?= $data['name'] ?>" required>
      </div>

      <div class="col-md-6 mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control" value="<?= $data['email'] ?>" required>
      </div>

      <div class="col-md-6 mb-3">
        <label>Phone</label>
        <input type="text" name="phone" class="form-control" value="<?= $data['mobile'] ?>" required>
      </div>

      <div class="col-md-6 mb-3">
        <label>Department</label>
        <select name="dept_id" class="form-select" required>
          <?php
          $dres = $conn->query("SELECT * FROM department");
          while ($d = $dres->fetch_assoc()) {
            $selected = ($d['dept_id'] == $data['dept_id']) ? 'selected' : '';
            echo "<option value='{$d['dept_id']}' $selected>{$d['dept_name']}</option>";
          }
          ?>
        </select>
      </div>

      <div class="col-md-6 mb-3">
        <label>Semester</label>
        <select name="semester_id" class="form-select" required>
          <?php
          $semres = $conn->query("SELECT * FROM semester");
          while ($sem = $semres->fetch_assoc()) {
            $selected = ($sem['semester_id'] == $data['semester_id']) ? 'selected' : '';
            echo "<option value='{$sem['semester_id']}' $selected>{$sem['semester_name']}</option>";
          }
          ?>
        </select>
      </div>

      <div class="col-md-6 mb-3">
        <label>Section</label>
        <select name="section_id" class="form-select" required>
          <?php
          $sres = $conn->query("SELECT * FROM section");
          while ($s = $sres->fetch_assoc()) {
            $selected = ($s['section_id'] == $data['section_id']) ? 'selected' : '';
            echo "<option value='{$s['section_id']}' $selected>{$s['section_name']}</option>";
          }
          ?>
        </select>
      </div>
    </div>

    <button type="submit" name="update_student" class="btn btn-primary">Update</button>
    <a href="admin_dashboard.php?section=students.php" class="btn btn-secondary">Cancel</a>
  </form>
</div>
        </head>

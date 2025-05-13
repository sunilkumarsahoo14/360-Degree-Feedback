<?php
// ✅ File: students.php
include '../dbconnect.php';
?>
<div class="container mt-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0">Student Management</h3>
    <a href="add_student_form.php" class="btn btn-success">Add Student</a>
  </div>

  <!-- Student Data Table -->
  <table class="table table-bordered table-striped">
    <thead class="table-dark">
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Department</th>
        <th>Semester</th>
        <th>Section</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $query = "SELECT s.*, d.dept_name, sec.section_name, sem.semester_name
                FROM student s
                LEFT JOIN department d ON s.dept_id = d.dept_id
                LEFT JOIN section sec ON s.section_id = sec.section_id
                LEFT JOIN semester sem ON s.semester_id = sem.semester_id";

      $result = $conn->query($query);

      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          echo "<tr>
            <td>{$row['user_id']}</td>
            <td>{$row['name']}</td>
            <td>{$row['email']}</td>
            <td>{$row['mobile']}</td>
            <td>{$row['dept_name']}</td>
            <td>{$row['semester_name']}</td>
            <td>{$row['section_name']}</td>
            <td>
              <a href='edit_student_form.php?id={$row['user_id']}' class='btn btn-warning btn-sm'>Edit</a>
              <a href='functions.php?delete_student={$row['user_id']}' class='btn btn-danger btn-sm' onclick=\"return confirm('Are you sure?')\">Delete</a>
            </td>
          </tr>";
        }
      } else {
        echo "<tr><td colspan='8' class='text-center'>No students found</td></tr>";
      }
      ?>
    </tbody>
  </table>
</div>

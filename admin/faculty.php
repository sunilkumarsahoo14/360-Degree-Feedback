<?php
session_start();
include '../dbconnect.php';

// Check if the session is active and if the user is an admin
$isAdmin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';

// Debug: Show session details for troubleshooting
// echo "Session role: " . $_SESSION['role'];

// If admin, check if the password column has data
// Debug: Check if role is 'admin' and session variable is set correctly
// if ($isAdmin) {
//    // echo "<div class='alert alert-success'>You are logged in as an admin.</div>";
// } else {
//     echo "<div class='alert alert-danger'>You are not logged in as an admin or session expired.</div>";
// }
?>

<div class="container mt-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0">Faculty Management</h3>
    <a href="add_faculty_form.php" class="btn btn-primary">+ Add Faculty</a>
  </div>

  <!-- Faculty Data Table -->
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
      // Query to get faculty details
      $query = "SELECT f.*, d.dept_name, s.semester_name, sec.section_name
                FROM faculty f
                LEFT JOIN department d ON f.dept_id = d.dept_id
                LEFT JOIN semester s ON f.semester_id = s.semester_id
                LEFT JOIN section sec ON f.section_id = sec.section_id";
      $result = $conn->query($query);

      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          // Display the hashed password only for admin
          $passwordDisplay = $isAdmin ? $row['password'] : 'Encrypted';

          echo "<tr>
            <td>{$row['user_id']}</td>
            <td>{$row['name']}</td>
            <td>{$row['email']}</td>
            <td>{$row['mobile']}</td>
            <td>{$row['dept_name']}</td>
            <td>{$row['section_name']}</td>
            <td>{$row['semester_name']}</td>
            
            
            <td>
              <a href='edit_faculty_form.php?id={$row['user_id']}' class='btn btn-warning btn-sm'>Edit</a>
              <a href='function_faculty.php?delete_faculty={$row['user_id']}' class='btn btn-danger btn-sm' onclick=\"return confirm('Are you sure?')\">Delete</a>
            </td>
          </tr>";
        }
      } else {
        echo "<tr><td colspan='9' class='text-center'>No faculty found</td></tr>";
      }
      ?>
    </tbody>
  </table>
</div>

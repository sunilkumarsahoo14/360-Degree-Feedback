<?php include '../dbconnect.php'; ?>

<div class="container mt-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0">HOD Management</h3>
    <!-- <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addHodModal">
      <i class="bi bi-person-plus"></i> Add New HOD
    </button> -->
    <a href="add_hod_form.php" class="btn btn-success">Add Hod</a>
  </div>

  <!-- HOD Data Table -->
  <table class="table table-bordered table-striped">
    <thead class="table-dark">
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Department</th>
       
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $query = "SELECT h.*, d.dept_name 
                FROM hod h
                LEFT JOIN department d ON h.dept_id = d.dept_id";

      $result = $conn->query($query);

      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          echo "<tr>
            <td>{$row['user_id']}</td>
            <td>{$row['name']}</td>
            <td>{$row['email']}</td>
            <td>{$row['mobile']}</td>
            <td>{$row['dept_name']}</td>
            
            <td>
              <a href='edit_hod_form.php?id={$row['user_id']}' class='btn btn-warning btn-sm'>Edit</a>
              <a href='function_hod.php?delete_hod={$row['user_id']}' class='btn btn-danger btn-sm' onclick=\"return confirm('Are you sure?')\">Delete</a>
            </td>
          </tr>";
        }
      } else {
        echo "<tr><td colspan='7' class='text-center'>No HODs found</td></tr>";
      }
      ?>
    </tbody>
  </table>
</div>

<!-- Add HOD Modal -->


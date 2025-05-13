<?php
session_start();
if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login_form.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Generate Feedback Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h3 class="mb-3 text-center">Generate Feedback Report</h3>

    <!-- Report Filter Form -->
    <form action="generate_report_action.php" method="POST" class="card p-4 shadow">
        <div class="row g-3">
            <!-- Select Role -->
            <div class="col-md-6">
                <label for="userType" class="form-label">Select User Type</label>
                <select id="userType" name="role" class="form-select" required>
                    <option value="">-- Select Role --</option>
                    <option value="student">Student</option>
                    <option value="faculty">Faculty</option>
                    <option value="hod">HOD</option>
                </select>
            </div>

            <!-- Select Email Dropdown -->
            <div class="col-md-6">
                <label for="userEmail" class="form-label">Select User Email</label>
                <select id="userEmail" name="email" class="form-select" required>
                    <option value="">-- Select Email --</option>
                </select>
            </div>
        </div>

        <div class="text-end mt-4">
            <button type="submit" class="btn btn-primary">Generate Report</button>
        </div>
    </form>
</div>

<!-- Load Email List Dynamically -->
<script>
document.getElementById('userType').addEventListener('change', function () {
    const role = this.value;
    const emailDropdown = document.getElementById('userEmail');

    emailDropdown.innerHTML = '<option value="">-- Select Email --</option>';

    if (role) {
        fetch(`fetch_emails.php?role=${role}`)
            .then(response => response.json())
            .then(emails => {
                emails.forEach(email => {
                    const option = document.createElement('option');
                    option.value = email;
                    option.textContent = email;
                    emailDropdown.appendChild(option);
                });
            })
            .catch(error => console.error('Error fetching emails:', error));
    }
});
</script>
</body>
</html>

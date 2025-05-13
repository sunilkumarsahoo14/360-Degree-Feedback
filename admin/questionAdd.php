<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Feedback Question</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white text-center">
                    <h4>Add Feedback Question</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="">
                        <div class="mb-3">
                            <label for="question" class="form-label">Enter Question</label>
                            <input type="text" name="question" id="question" class="form-control" required autocomplete="off">
                        </div>

                        <div class="mb-3">
                            <label for="role" class="form-label">Assign to Role</label>
                            <select name="role" id="role" class="form-select" required>
                                <option value="">Select Role</option>
                                <option value="student">Student</option>
                                <option value="faculty">Faculty</option>
                                <option value="hod">HOD</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-success w-100">Add Question</button>
                    </form>
                </div>
            </div>
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                include("../dbconnect.php"); // update path as needed

                $question = trim($_POST['question']);
                $role = $_POST['role'];

                $table = "";
                if ($role == 'student') {
                    $table = "student_questions";
                } elseif ($role == 'faculty') {
                    $table = "faculty_questions";
                } elseif ($role == 'hod') {
                    $table = "hod_questions";
                }

                if (!empty($table)) {
                    $stmt = $conn->prepare("INSERT INTO $table (question) VALUES (?)");
                    $stmt->bind_param("s", $question);

                    if ($stmt->execute()) {
                        echo "<div class='alert alert-success mt-3'>✅ Question added successfully to <strong>$role</strong> question table.</div>";
                    } else {
                        echo "<div class='alert alert-danger mt-3'>❌ Error: " . $stmt->error . "</div>";
                    }
                } else {
                    echo "<div class='alert alert-warning mt-3'>⚠️ Invalid role selected.</div>";
                }
            }
            ?>
        </div>
    </div>
</div>

</body>
</html>

<?php
include('../dbconnect.php');

$roles = ['student', 'hod', 'faculty'];
$roleColors = [
    'student' => 'primary',
    'hod' => 'warning',
    'faculty' => 'success'
];

function getUsersByRole($conn, $role) {
    $stmt = $conn->prepare("SELECT user_email, average_rating FROM average_ratings WHERE role = ?");
    $stmt->bind_param("s", $role);
    $stmt->execute();
    return $stmt->get_result();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .role-card { cursor: pointer; color: white; }
        .user-list { display: none; }
    </style>
</head>
<body class="bg-light">
<div class="container py-4">
    <h2 class="mb-4 text-center">Generated Reports by Role</h2>
    <div class="row g-4">
        <?php foreach ($roles as $role): ?>
            <div class="col-md-4">
                <div class="card role-card bg-<?= $roleColors[$role] ?> shadow" data-role="<?= $role ?>">
                    <div class="card-body text-center">
                        <h5 class="card-title text-capitalize"><?= $role ?></h5>
                        <p class="card-text">Click to view <?= $role ?> report</p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="mt-4">
        <?php foreach ($roles as $role): ?>
            <div id="<?= $role ?>-list" class="user-list mt-3">
                <h4><?= ucfirst($role) ?> Reports</h4>
                <table class="table table-bordered table-striped">
                    <thead class="table-<?= $roleColors[$role] ?>">
                        <tr>
                            <th>Email</th>
                            <th>Average Rating</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $result = getUsersByRole($conn, $role);
                        while ($row = $result->fetch_assoc()):
                        ?>
                            <tr>
                                <td><?= $row['user_email'] ?></td>
                                <td><?= $row['average_rating'] ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
    document.querySelectorAll('.role-card').forEach(card => {
        card.addEventListener('click', () => {
            const role = card.getAttribute('data-role');
            document.querySelectorAll('.user-list').forEach(list => list.style.display = 'none');
            document.getElementById(`${role}-list`).style.display = 'block';
            window.scrollTo({ top: document.getElementById(`${role}-list`).offsetTop - 70, behavior: 'smooth' });
        });
    });
</script>
</body>
</html>

<?php
include('../dbconnect.php');

// Fetch unique feedback types
$feedbackTypes = [];
$typeQuery = $conn->query("SELECT DISTINCT feedback_type FROM questions");
while ($row = $typeQuery->fetch_assoc()) {
    $feedbackTypes[] = $row['feedback_type'];
}

// Function to get questions by feedback type
function getQuestionsByFeedbackType($conn, $type) {
    $stmt = $conn->prepare("SELECT question_text, role FROM questions WHERE feedback_type = ?");
    $stmt->bind_param("s", $type);
    $stmt->execute();
    return $stmt->get_result();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Questions by Feedback Type</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .feedback-card {
            cursor: pointer;
            color: white;
            transition: transform 0.2s;
        }
        .feedback-card:hover {
            transform: scale(1.03);
        }
        .question-section {
            display: none;
        }
    </style>
</head>
<body class="bg-light">
<div class="container py-4">
    <h2 class="mb-4 text-center">Questions Grouped by Feedback Type</h2>

    <!-- Feedback Type Cards -->
    <div class="row g-4">
        <?php foreach ($feedbackTypes as $index => $type): ?>
            <div class="col-md-6">
                <div class="card feedback-card bg-primary shadow h-100" data-type="<?= $index ?>">
                    <div class="card-body text-center text-white">
                        <h5 class="card-title"><?= ucwords(str_replace('-', ' ', $type)) ?></h5>
                        <p class="card-text">Click to view questions</p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Questions per Feedback Type -->
    <div class="mt-5">
        <?php foreach ($feedbackTypes as $index => $type): ?>
            <div id="section-<?= $index ?>" class="question-section mt-4">
                <h4 class="mb-3"><?= ucwords(str_replace('-', ' ', $type)) ?> Questions</h4>
                <?php
                $result = getQuestionsByFeedbackType($conn, $type);
                if ($result->num_rows > 0):
                ?>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-primary">
                                <tr>
                                    <th>Question</th>
                                    <th>Role</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td><?= $row['question_text'] ?></td>
                                        <td><?= ucfirst($row['role']) ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="alert alert-warning text-center">No questions found for this feedback type.</div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- JavaScript to handle feedback card click -->
<script>
    document.querySelectorAll('.feedback-card').forEach(card => {
        card.addEventListener('click', () => {
            const typeIndex = card.getAttribute('data-type');
            document.querySelectorAll('.question-section').forEach(section => section.style.display = 'none');
            const target = document.getElementById(`section-${typeIndex}`);
            target.style.display = 'block';
            window.scrollTo({ top: target.offsetTop - 70, behavior: 'smooth' });
        });
    });
</script>
</body>
</html>

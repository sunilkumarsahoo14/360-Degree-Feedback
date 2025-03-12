<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>360 Feedback System - Login</title>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f7f9;
        }
        .error-message {
            color: red;
            font-weight: bold;
            text-align: center;
        }
    </style>
</head>
<body class="d-flex justify-content-center align-items-center vh-100">

<div class="card p-4 shadow-lg rounded-3" style="max-width: 400px; width: 100%;">
    <h2 class="text-center text-primary fw-bold">Login</h2>

    <!-- Display error message if present -->
    <?php if (isset($_GET['error'])): ?>
        <p class="error-message"><?= htmlspecialchars($_GET['error']) ?></p>
    <?php endif; ?>

    <form action="login_form_data.php" method="post">
        <div class="mb-3">
            <label class="form-label" for="email">Email:</label>
            <input class="form-control rounded-pill" type="email" name="email" id="email" required>
        </div>
        <div class="mb-3">
            <label class="form-label" for="password">Password:</label>
            <input class="form-control rounded-pill" type="password" name="password" id="password" required>
        </div>
        <div class="mb-3">
            <label class="form-label" for="user">User Type:</label>
            <select name="user" id="user" class="form-select rounded-pill">
                <option value="admin">Admin</option>
            </select>
        </div>
        <button class="btn btn-primary w-100 rounded-pill" type="submit">Login</button>
    </form>
</div>

<script src="assets/js/bootstrap.bundle.js"></script>
</body>
</html>

<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body { display: flex; }
        .sidebar {
            width: 250px;
            background: #343a40;
            color: white;
            min-height: 100vh;
            padding-top: 20px;
        }
        .sidebar a {
            color: white;
            padding: 10px;
            display: block;
            text-decoration: none;
        }
        .sidebar a:hover, .sidebar a.active {
            background: #495057;
        }
        .content { flex-grow: 1; padding: 20px; }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h4 class="text-center">Admin Panel</h4>
        <a href="#">Dashboard</a>
        <a href="#">Subjects</a>
        <a href="#">Classes</a>
        <a href="#">Faculties</a>
        <a href="#">HODs</a>
        <a href="#">Students</a>
        <a href="#">Generate Report</a>
    </div>
    
    <!-- Main Content -->
    <div class="content">
        <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
            <div class="container-fluid">
                <span class="navbar-brand">Admin Dashboard</span>
                <div class="ms-auto">
                    <span class="me-3">Welcome, Admin</span>
                    <a href="#" class="nav-link text-dark" id="openProfileModal" data-bs-toggle="modal" data-bs-target="#adminProfileModal">Profile & Settings</a>
                </div>
            </div>
        </nav>
        
        <!-- Admin Profile Modal -->
        <div class="modal fade" id="adminProfileModal" tabindex="-1" aria-labelledby="adminProfileModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="adminProfileModalLabel">Admin Profile</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>ID:</strong> <span id="admin_id"></span></p>
                        <p><strong>Name:</strong> <span id="admin_name"></span></p>
                        <p><strong>Mobile:</strong> <span id="admin_mobile"></span></p>
                        <p><strong>Email:</strong> <span id="admin_email"></span></p>
                        <p><strong>Password:</strong> <span id="admin_password">********</span></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Dashboard Cards -->
        <div class="row">
            <div class="col-md-3"><div class="card text-white bg-primary mb-3"><div class="card-body"><h5 class="card-title">Subjects</h5><p class="card-text">Total: 10</p></div></div></div>
            <div class="col-md-3"><div class="card text-white bg-success mb-3"><div class="card-body"><h5 class="card-title">Classes</h5><p class="card-text">Total: 5</p></div></div></div>
            <div class="col-md-3"><div class="card text-white bg-warning mb-3"><div class="card-body"><h5 class="card-title">Faculties</h5><p class="card-text">Total: 20</p></div></div></div>
            <div class="col-md-3"><div class="card text-white bg-danger mb-3"><div class="card-body"><h5 class="card-title">Students</h5><p class="card-text">Total: 200</p></div></div></div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        document.getElementById("openProfileModal").addEventListener("click", function() {
            fetch("./fetch_admin.php")
            .then(response => {
                if (!response.ok) throw new Error("Failed to fetch admin data.");
                return response.json();
            })
            .then(data => {
                if (data.id) {
                    document.getElementById("admin_id").textContent = data.id;
                    document.getElementById("admin_name").textContent = data.name;
                    document.getElementById("admin_mobile").textContent = data.mobile || "Not Available";
                    document.getElementById("admin_email").textContent = data.email;
                    document.getElementById("admin_password").textContent = "********"; 
                } else {
                    alert("Admin data not found.");
                }
            })
            .catch(error => alert("Error: " + error.message));
        });

        // Highlight Active Sidebar Link
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll(".sidebar a").forEach(link => {
                if (window.location.href.includes(link.href)) link.classList.add("active");
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

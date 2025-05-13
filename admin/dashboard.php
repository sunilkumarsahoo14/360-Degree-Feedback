<?php
// ✅ File: admin_dashboard.php
include '../dbconnect.php';

// Fetch counts from database
$totalStudents = $conn->query("SELECT COUNT(*) AS total FROM student")->fetch_assoc()['total'];
$totalFaculties = $conn->query("SELECT COUNT(*) AS total FROM faculty")->fetch_assoc()['total'];
$totalHODs = $conn->query("SELECT COUNT(*) AS total FROM hod")->fetch_assoc()['total'];
$totalReports = $conn->query("SELECT COUNT(*) AS total FROM average_ratings")->fetch_assoc()['total'];
?>

<div class="container-fluid">
    <div class="row">
        <!-- Dashboard Heading -->
        <div class="col-12 mb-4">
            <h3 class="text-primary">Dashboard Overview</h3>
        </div>

        <!-- Summary Cards -->
        <div class="col-md-3">
            <div class="card bg-primary text-white shadow">
                <div class="card-body">
                    <h5>Total Students</h5>
                    <h3><?= $totalStudents ?></h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-success text-white shadow">
                <div class="card-body">
                    <h5>Total Faculties</h5>
                    <h3><?= $totalFaculties ?></h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-warning text-dark shadow">
                <div class="card-body">
                    <h5>Total HODs</h5>
                    <h3><?= $totalHODs ?></h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-danger text-white shadow">
                <div class="card-body">
                    <h5>Reports Generated</h5>
                    <h3><?= $totalReports ?></h3>
                </div>
            </div>
        </div>
    </div>
</div>

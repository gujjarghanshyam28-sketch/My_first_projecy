<?php
require_once __DIR__ . '/auth.php';
$page_title = $page_title ?? 'Student Management System';
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e($page_title) ?> | SMS</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
 <div class="container">
  <a class="navbar-brand fw-bold" href="<?= !empty($_SESSION['admin_id']) ? 'dashboard.php' : 'login.php' ?>">Student Management</a>
  <?php if (!empty($_SESSION['admin_id'])): ?>
  <div class="navbar-nav ms-auto flex-row flex-wrap gap-3">
   <a class="nav-link text-white" href="dashboard.php">Dashboard</a>
   <a class="nav-link text-white" href="students.php">Students</a>
   <a class="nav-link text-white" href="courses.php">Courses</a>
   <a class="nav-link text-white" href="attendance.php">Attendance</a>
   <a class="nav-link text-white" href="logout.php">Logout</a>
  </div>
  <?php endif; ?>
 </div>
</nav>
<main class="container py-4">

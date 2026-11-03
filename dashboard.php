<?php
require_once 'config/database.php'; require_once 'includes/auth.php'; require_login();
$students = (int)$pdo->query('SELECT COUNT(*) FROM students')->fetchColumn();
$courses = (int)$pdo->query('SELECT COUNT(*) FROM courses')->fetchColumn();
$attendance = (int)$pdo->query('SELECT COUNT(*) FROM attendance')->fetchColumn();
$page_title = 'Dashboard'; include 'includes/header.php';
?>
<h1 class="h3 mb-4">Welcome, <?= e($_SESSION['admin_name'] ?? 'Admin') ?></h1>
<div class="row g-3">
 <?php foreach ([['Total Students',$students],['Total Courses',$courses],['Attendance Entries',$attendance]] as $item): ?>
 <div class="col-md-4"><div class="card p-4"><div class="text-muted"><?= e($item[0]) ?></div><div class="stat-number"><?= $item[1] ?></div></div></div>
 <?php endforeach; ?>
</div>
<div class="card p-4 mt-4">
 <h2 class="h5">Quick actions</h2>
 <div class="d-flex flex-wrap gap-2">
  <a class="btn btn-primary" href="student_form.php">Add Student</a>
  <a class="btn btn-outline-primary" href="students.php">Manage Students</a>
  <a class="btn btn-outline-primary" href="courses.php">Manage Courses</a>
  <a class="btn btn-outline-primary" href="attendance.php">Mark Attendance</a>
 </div>
</div>
<?php include 'includes/footer.php'; ?>

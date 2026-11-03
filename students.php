<?php
require_once 'config/database.php'; require_once 'includes/auth.php'; require_login();
$q = trim($_GET['q'] ?? '');
$sql = "SELECT s.*, c.course_name FROM students s LEFT JOIN courses c ON c.id=s.course_id
        WHERE s.name LIKE ? OR s.roll_no LIKE ? OR s.email LIKE ? ORDER BY s.id DESC";
$stmt = $pdo->prepare($sql); $like = "%$q%"; $stmt->execute([$like,$like,$like]); $students = $stmt->fetchAll();
$page_title = 'Students'; include 'includes/header.php';
?>
<div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
 <h1 class="h3 mb-0">Student Records</h1><a class="btn btn-primary" href="student_form.php">Add Student</a>
</div>
<form class="row g-2 mb-3"><div class="col-sm-8"><input class="form-control" name="q" value="<?= e($q) ?>" placeholder="Search name, roll number or email"></div><div class="col-auto"><button class="btn btn-outline-primary">Search</button></div><div class="col-auto"><a class="btn btn-outline-secondary" href="students.php">Clear</a></div></form>
<div class="card p-3"><div class="table-responsive"><table class="table table-hover align-middle mb-0">
<thead><tr><th>Roll No.</th><th>Name</th><th>Email</th><th>Phone</th><th>Course</th><th>Actions</th></tr></thead><tbody>
<?php foreach ($students as $s): ?><tr>
<td><?= e($s['roll_no']) ?></td><td><?= e($s['name']) ?></td><td><?= e($s['email']) ?></td><td><?= e($s['phone']) ?></td><td><?= e($s['course_name'] ?? '—') ?></td>
<td class="text-nowrap"><a class="btn btn-sm btn-outline-primary" href="student_form.php?id=<?= (int)$s['id'] ?>">Edit</a>
<form class="d-inline" method="post" action="student_delete.php" onsubmit="return confirm('Delete this student?')">
<input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>"><input type="hidden" name="id" value="<?= (int)$s['id'] ?>"><button class="btn btn-sm btn-outline-danger">Delete</button></form></td>
</tr><?php endforeach; ?>
<?php if (!$students): ?><tr><td colspan="6" class="text-center text-muted py-4">No student records found.</td></tr><?php endif; ?>
</tbody></table></div></div>
<?php include 'includes/footer.php'; ?>

<?php
require_once 'config/database.php'; require_once 'includes/auth.php'; require_login();
$error='';
if($_SERVER['REQUEST_METHOD']==='POST'){
 verify_csrf(); $name=trim($_POST['course_name']??''); $code=trim($_POST['course_code']??''); $desc=trim($_POST['description']??'');
 if($name==='') $error='Course name is required.';
 else { try{$st=$pdo->prepare('INSERT INTO courses(course_name,course_code,description) VALUES(?,?,?)');$st->execute([$name,$code,$desc]);header('Location: courses.php');exit;}catch(PDOException $e){$error='Could not add course. Course code may already exist.';} }
}
$courses=$pdo->query('SELECT c.*, (SELECT COUNT(*) FROM students s WHERE s.course_id=c.id) AS student_count FROM courses c ORDER BY c.course_name')->fetchAll();
$page_title='Courses'; include 'includes/header.php';
?>
<h1 class="h3 mb-3">Course Management</h1>
<?php if($error): ?><div class="alert alert-danger"><?= e($error) ?></div><?php endif; ?>
<div class="row g-3"><div class="col-lg-4"><div class="card p-3"><h2 class="h5">Add Course</h2>
<form method="post"><input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
<div class="mb-2"><label class="form-label">Course Name *</label><input class="form-control" name="course_name" required></div>
<div class="mb-2"><label class="form-label">Course Code</label><input class="form-control" name="course_code"></div>
<div class="mb-3"><label class="form-label">Description</label><textarea class="form-control" name="description" rows="3"></textarea></div>
<button class="btn btn-primary">Add Course</button></form></div></div>
<div class="col-lg-8"><div class="card p-3"><div class="table-responsive"><table class="table align-middle">
<thead><tr><th>Course</th><th>Code</th><th>Students</th><th>Description</th></tr></thead><tbody>
<?php foreach($courses as $c): ?><tr><td><?= e($c['course_name']) ?></td><td><?= e($c['course_code']) ?></td><td><?= (int)$c['student_count'] ?></td><td><?= e($c['description']) ?></td></tr><?php endforeach; ?>
<?php if(!$courses): ?><tr><td colspan="4" class="text-muted text-center">No courses added yet.</td></tr><?php endif; ?>
</tbody></table></div></div></div></div>
<?php include 'includes/footer.php'; ?>

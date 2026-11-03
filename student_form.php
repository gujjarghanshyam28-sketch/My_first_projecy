<?php
require_once 'config/database.php'; require_once 'includes/auth.php'; require_login();
$id = (int)($_GET['id'] ?? 0); $student = ['roll_no'=>'','name'=>'','email'=>'','phone'=>'','gender'=>'','dob'=>'','address'=>'','course_id'=>''];
if ($id) { $stmt=$pdo->prepare('SELECT * FROM students WHERE id=?'); $stmt->execute([$id]); $student=$stmt->fetch(); if (!$student) exit('Student not found.'); }
$error = '';
if ($_SERVER['REQUEST_METHOD']==='POST') {
 verify_csrf();
 $data = [
  trim($_POST['roll_no'] ?? ''), trim($_POST['name'] ?? ''), trim($_POST['email'] ?? ''),
  trim($_POST['phone'] ?? ''), $_POST['gender'] ?? '', $_POST['dob'] ?: null,
  trim($_POST['address'] ?? ''), ($_POST['course_id'] ?? '') !== '' ? (int)$_POST['course_id'] : null
 ];
 if ($data[0]==='' || $data[1]==='') $error='Roll number and student name are required.';
 else {
  try {
   if ($id) { $data[]=$id; $stmt=$pdo->prepare('UPDATE students SET roll_no=?,name=?,email=?,phone=?,gender=?,dob=?,address=?,course_id=? WHERE id=?'); }
   else { $stmt=$pdo->prepare('INSERT INTO students (roll_no,name,email,phone,gender,dob,address,course_id) VALUES (?,?,?,?,?,?,?,?)'); }
   $stmt->execute($data); header('Location: students.php'); exit;
  } catch (PDOException $ex) { $error='Could not save record. Check that the roll number and email are unique.'; }
 }
 $student=array_combine(['roll_no','name','email','phone','gender','dob','address','course_id'],$data);
}
$courses=$pdo->query('SELECT id,course_name FROM courses ORDER BY course_name')->fetchAll();
$page_title=$id?'Edit Student':'Add Student'; include 'includes/header.php';
?>
<div class="card p-4 form-card"><h1 class="h3 mb-3"><?= e($page_title) ?></h1>
<?php if($error): ?><div class="alert alert-danger"><?= e($error) ?></div><?php endif; ?>
<form method="post"><input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
<div class="row g-3">
<div class="col-md-6"><label class="form-label">Roll Number *</label><input class="form-control" name="roll_no" required value="<?= e($student['roll_no']) ?>"></div>
<div class="col-md-6"><label class="form-label">Full Name *</label><input class="form-control" name="name" required value="<?= e($student['name']) ?>"></div>
<div class="col-md-6"><label class="form-label">Email</label><input class="form-control" type="email" name="email" value="<?= e($student['email']) ?>"></div>
<div class="col-md-6"><label class="form-label">Phone</label><input class="form-control" name="phone" value="<?= e($student['phone']) ?>"></div>
<div class="col-md-6"><label class="form-label">Gender</label><select class="form-select" name="gender"><option value="">Select</option><?php foreach(['Male','Female','Other'] as $g): ?><option <?= $student['gender']===$g?'selected':'' ?>><?= e($g) ?></option><?php endforeach; ?></select></div>
<div class="col-md-6"><label class="form-label">Date of Birth</label><input class="form-control" type="date" name="dob" value="<?= e($student['dob']) ?>"></div>
<div class="col-md-6"><label class="form-label">Course</label><select class="form-select" name="course_id"><option value="">Unassigned</option><?php foreach($courses as $c): ?><option value="<?= (int)$c['id'] ?>" <?= (string)$student['course_id']===(string)$c['id']?'selected':'' ?>><?= e($c['course_name']) ?></option><?php endforeach; ?></select></div>
<div class="col-12"><label class="form-label">Address</label><textarea class="form-control" name="address" rows="2"><?= e($student['address']) ?></textarea></div>
</div><div class="mt-4 d-flex gap-2"><button class="btn btn-primary">Save Student</button><a class="btn btn-outline-secondary" href="students.php">Cancel</a></div>
</form></div>
<?php include 'includes/footer.php'; ?>

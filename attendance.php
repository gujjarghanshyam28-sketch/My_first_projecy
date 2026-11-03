<?php
require_once 'config/database.php'; require_once 'includes/auth.php'; require_login();
$error='';
if($_SERVER['REQUEST_METHOD']==='POST'){
 verify_csrf(); $sid=(int)($_POST['student_id']??0); $date=$_POST['attendance_date']??date('Y-m-d'); $status=$_POST['status']??'Present'; $remarks=trim($_POST['remarks']??'');
 if(!in_array($status,['Present','Absent','Late'],true)) $error='Invalid attendance status.';
 else { try{$st=$pdo->prepare('INSERT INTO attendance(student_id,attendance_date,status,remarks) VALUES(?,?,?,?) ON DUPLICATE KEY UPDATE status=VALUES(status), remarks=VALUES(remarks)');$st->execute([$sid,$date,$status,$remarks]);header('Location: attendance.php');exit;}catch(PDOException $e){$error='Could not save attendance. Select a valid student.';} }
}
$students=$pdo->query('SELECT id,roll_no,name FROM students ORDER BY name')->fetchAll();
$records=$pdo->query('SELECT a.*,s.roll_no,s.name FROM attendance a JOIN students s ON s.id=a.student_id ORDER BY attendance_date DESC,a.id DESC LIMIT 100')->fetchAll();
$page_title='Attendance'; include 'includes/header.php';
?>
<h1 class="h3 mb-3">Attendance Management</h1>
<?php if($error): ?><div class="alert alert-danger"><?= e($error) ?></div><?php endif; ?>
<div class="card p-3 mb-4"><h2 class="h5">Mark Attendance</h2>
<?php if(!$students): ?><p class="text-muted mb-0">Add students before recording attendance.</p><?php else: ?>
<form method="post" class="row g-3"><input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
<div class="col-md-4"><label class="form-label">Student</label><select class="form-select" name="student_id" required><?php foreach($students as $s): ?><option value="<?= (int)$s['id'] ?>"><?= e($s['roll_no'].' — '.$s['name']) ?></option><?php endforeach; ?></select></div>
<div class="col-md-3"><label class="form-label">Date</label><input class="form-control" type="date" name="attendance_date" value="<?= date('Y-m-d') ?>" required></div>
<div class="col-md-2"><label class="form-label">Status</label><select class="form-select" name="status"><option>Present</option><option>Absent</option><option>Late</option></select></div>
<div class="col-md-3"><label class="form-label">Remarks</label><input class="form-control" name="remarks"></div>
<div class="col-12"><button class="btn btn-primary">Save Attendance</button></div></form><?php endif; ?></div>
<div class="card p-3"><h2 class="h5">Recent Attendance (latest 100)</h2><div class="table-responsive"><table class="table">
<thead><tr><th>Date</th><th>Roll No.</th><th>Student</th><th>Status</th><th>Remarks</th></tr></thead><tbody>
<?php foreach($records as $r): ?><tr><td><?= e($r['attendance_date']) ?></td><td><?= e($r['roll_no']) ?></td><td><?= e($r['name']) ?></td><td><?= e($r['status']) ?></td><td><?= e($r['remarks']) ?></td></tr><?php endforeach; ?>
<?php if(!$records): ?><tr><td colspan="5" class="text-center text-muted">No attendance records yet.</td></tr><?php endif; ?>
</tbody></table></div></div>
<?php include 'includes/footer.php'; ?>

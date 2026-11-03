<?php
require_once 'config/database.php';
require_once 'includes/auth.php';
if (!empty($_SESSION['admin_id'])) { header('Location: dashboard.php'); exit; }
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $stmt = $pdo->prepare('SELECT id, username, password_hash FROM admins WHERE username = ?');
    $stmt->execute([trim($_POST['username'] ?? '')]);
    $admin = $stmt->fetch();
    if ($admin && password_verify($_POST['password'] ?? '', $admin['password_hash'])) {
        session_regenerate_id(true);
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_name'] = $admin['username'];
        header('Location: dashboard.php'); exit;
    }
    $error = 'Invalid username or password.';
}
$page_title = 'Admin Login'; include 'includes/header.php';
?>
<div class="row justify-content-center mt-5"><div class="col-md-5">
 <div class="card p-4">
  <h1 class="h4 mb-3">Administrator Login</h1>
  <?php if ($error): ?><div class="alert alert-danger"><?= e($error) ?></div><?php endif; ?>
  <form method="post">
   <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
   <div class="mb-3"><label class="form-label">Username</label><input class="form-control" name="username" required autocomplete="username"></div>
   <div class="mb-3"><label class="form-label">Password</label><input class="form-control" type="password" name="password" required autocomplete="current-password"></div>
   <button class="btn btn-primary w-100">Login</button>
  </form>
  <p class="text-muted small mt-3 mb-0">Demo account: admin / password</p>
 </div>
</div></div>
<?php include 'includes/footer.php'; ?>

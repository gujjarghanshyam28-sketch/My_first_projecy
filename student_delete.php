<?php
require_once 'config/database.php'; require_once 'includes/auth.php'; require_login();
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: students.php'); exit; }
verify_csrf();
$id=(int)($_POST['id'] ?? 0);
$stmt=$pdo->prepare('DELETE FROM students WHERE id=?'); $stmt->execute([$id]);
header('Location: students.php'); exit;

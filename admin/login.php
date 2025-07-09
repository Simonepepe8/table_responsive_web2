<?php
require 'db.php';
session_start();

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = trim($_POST['username']);
  $password = trim($_POST['password']);

  $stmt = $conn->prepare("SELECT id, password, role FROM users WHERE username = ?");
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $stmt->store_result();

  if ($stmt->num_rows == 1) {
    $stmt->bind_result($id, $hashedPassword, $role);
    $stmt->fetch();
    if (password_verify($password, $hashedPassword)) {
      $_SESSION['user'] = [
        'id' => $id,
        'username' => $username,
        'role' => $role
      ];
      // ✅ เปลี่ยนเส้นทางตาม role
      if ($role === 'admin') {
        header("Location: admin/index.php");
      } else {
        header("Location: frontend/index.php");
      }
      exit;
    } else {
      $error = "รหัสผ่านไม่ถูกต้อง";
    }
  } else {
    $error = "ไม่พบชื่อผู้ใช้นี้";
  }
  $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>เข้าสู่ระบบ</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <h2>เข้าสู่ระบบ</h2>
  <?php if ($error): ?>
    <div class="alert error"><?= $error ?></div>
  <?php endif; ?>
  <form method="post" class="form">
    <label>ชื่อผู้ใช้: <input type="text" name="username" required></label>
    <label>รหัสผ่าน: <input type="password" name="password" required></label>
    <button type="submit" class="btn">เข้าสู่ระบบ</button>
    <p>ยังไม่มีบัญชี? <a href="register.php">สมัครสมาชิก</a></p>
  </form>
</body>
</html>

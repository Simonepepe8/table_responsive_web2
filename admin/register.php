<?php
require 'db.php';
session_start();

if (isset($_SESSION['user'])) {
  header("Location: index.php");
  exit;
}

$msg = '';
$error = '';
$REQUIRED_KEY = "join2025"; // 🔐 กำหนดรหัสที่ต้องใช้ตอนสมัคร

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = trim($_POST['username']);
  $password = trim($_POST['password']);
  $confirm = trim($_POST['confirm_password']);
  $key = trim($_POST['key']);

  if (!$username || !$password || !$confirm || !$key) {
    $error = "กรุณากรอกข้อมูลให้ครบทุกช่อง";
  } elseif ($password !== $confirm) {
    $error = "รหัสผ่านไม่ตรงกัน";
  } elseif ($key !== $REQUIRED_KEY) {
    $error = "รหัสลงทะเบียนไม่ถูกต้อง";
  } else {
    // ตรวจสอบชื่อซ้ำ
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
      $error = "ชื่อผู้ใช้นี้มีอยู่แล้ว";
    } else {
      $hash = password_hash($password, PASSWORD_DEFAULT);
      $role = 'staff';

      $insert = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
      $insert->bind_param("sss", $username, $hash, $role);
      if ($insert->execute()) {
        $msg = "สมัครสมาชิกสำเร็จ! กรุณาเข้าสู่ระบบ";
      } else {
        $error = "เกิดข้อผิดพลาดในการสมัคร";
      }
      $insert->close();
    }
    $stmt->close();
  }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>สมัครสมาชิก</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <h2>สมัครสมาชิก (Staff เท่านั้น)</h2>

  <?php if ($msg): ?>
    <div class="alert success"><?= $msg ?></div>
  <?php elseif ($error): ?>
    <div class="alert error"><?= $error ?></div>
  <?php endif; ?>

  <form method="post" class="form">
    <label>ชื่อผู้ใช้: <input type="text" name="username" required></label>
    <label>รหัสผ่าน: <input type="password" name="password" required></label>
    <label>ยืนยันรหัสผ่าน: <input type="password" name="confirm_password" required></label>
    <label>รหัสลงทะเบียน: <input type="text" name="key" required placeholder="กรอกรหัสที่ได้รับ"></label>
    <button type="submit" class="btn">สมัครสมาชิก</button>
    <p>มีบัญชีแล้ว? <a href="login.php">เข้าสู่ระบบ</a></p>
  </form>
</body>
</html>

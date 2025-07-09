<?php
require 'db.php';
session_start();

if (isset($_SESSION['user'])) {
  header("Location: login.php");
  exit;
}

$msg = '';
$error = '';
$ADMIN_KEY = "join2025"; // 🔐 รหัสลับ admin

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = trim($_POST['username']);
  $password = trim($_POST['password']);
  $confirm = trim($_POST['confirm_password']);
  $role = $_POST['role'];
  $key = isset($_POST['key']) ? trim($_POST['key']) : '';

  if (!$username || !$password || !$confirm || !$role) {
    $error = "กรุณากรอกข้อมูลให้ครบถ้วน";
  } elseif ($password !== $confirm) {
    $error = "รหัสผ่านไม่ตรงกัน";
  } elseif ($role === 'admin' && $key !== $ADMIN_KEY) {
    $error = "รหัสลงทะเบียนสำหรับ Admin ไม่ถูกต้อง";
  } else {
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
      $error = "ชื่อผู้ใช้นี้มีอยู่แล้ว";
    } else {
      $hash = password_hash($password, PASSWORD_DEFAULT);
      $insert = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
      $insert->bind_param("sss", $username, $hash, $role);
      if ($insert->execute()) {
        header("Location: login.php"); // ✅ ทุกคนไป login หลังสมัคร
        exit;
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
  <script>
    function toggleKeyField() {
      const role = document.querySelector('select[name="role"]').value;
      document.getElementById('admin-key').style.display = role === 'admin' ? 'block' : 'none';
    }
  </script>
</head>
<body>
  <h2>สมัครสมาชิก</h2>

  <?php if ($msg): ?>
    <div class="alert success"><?= $msg ?></div>
  <?php elseif ($error): ?>
    <div class="alert error"><?= $error ?></div>
  <?php endif; ?>

  <form method="post" class="form">
    <label>ชื่อผู้ใช้: <input type="text" name="username" required></label>
    <label>รหัสผ่าน: <input type="password" name="password" required></label>
    <label>ยืนยันรหัสผ่าน: <input type="password" name="confirm_password" required></label>
    <label>สมัครเป็น:
      <select name="role" onchange="toggleKeyField()" required>
        <option value="staff" selected>Staff</option>
        <option value="admin">Admin</option>
      </select>
    </label>
    <div id="admin-key" style="display: none;">
      <label>รหัสสำหรับแอดมิน: <input type="text" name="key"></label>
    </div>
    <button type="submit" class="btn">สมัครสมาชิก</button>
    <p>มีบัญชีแล้ว? <a href="login.php">เข้าสู่ระบบ</a></p>
  </form>
</body>
</html>

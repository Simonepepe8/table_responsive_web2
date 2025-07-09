
<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // ปรับเป็น auth จริงได้ later
    if ($user === 'admin' && $pass === 'admin123') {
        $_SESSION['user'] = $user;
        header("Location: index.php");
        exit;
    } else {
        $error = "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
  <link rel="stylesheet" href="login.css">
</head>
<body>
    
  <div class="login-container">
    <h2>เข้าสู่ระบบจัดการพนักงาน</h2>
    <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
    <form method="POST">
      <input type="text" name="username" placeholder="Username" required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit">เข้าสู่ระบบ</button>
    </form>
  </div>
</body>
</html>

<?php
require 'auth.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Employee Dashboard</title>
  <link rel="stylesheet" href="style.css" />

  <!-- DataTables CSS -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css" />
</head>
<body>
  <header>
    <h1>Employee Dashboard</h1>
    <a href="logout.php" class="logout-btn">ออกจากระบบ</a>
  </header>

  <main>
    <div class="actions">
      <a href="add.php" class="btn">+ เพิ่มพนักงาน</a>
      <!-- สามารถเพิ่มปุ่ม Export / Import / อื่น ๆ ได้ที่นี่ -->
    </div>

    <table id="employeeTable" class="display nowrap" style="width:100%">
      <thead>
        <tr>
          <th>ID</th>
          <th>First name</th>
          <th>Last name</th>
          <th>Email</th>
          <th>Position</th>
          <th>Gender</th>
          <th>Actions</th>
        </tr>
      </thead>
    </table>
  </main>

  <!-- JS -->
  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
  <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
  <script src="script.js"></script>
</body>
</html>


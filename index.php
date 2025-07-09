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
  <header></header>
    <h1>Employee Dashboard</h1>
  </header>
  <main>
    <!--<label for="genderFilter">Filter by Gender:</label>
    <select id="genderFilter">
      <option value="">All</option>
      <option value="Male">Male</option>
    <option value="Female">Female</option>
  </select>-->

  <!--<div class="table-container">-->
    <table id="employeeTable" class="display">
      <thead>
        <tr>
          <th>ID</th>
          <th>First name</th>
          <th>Last name</th>
          <th>Email</th>
          <th>Position</th>
          <th>Gender</th>
        </tr>
      </thead>
    </table>
 <!-- </div>-->

  <!-- JS -->
  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
  <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
  <script src="script.js"></script>
</body>
</html>

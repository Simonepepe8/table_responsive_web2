$(document).ready(function () {
  const table = $('#employeeTable').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
      url: '../admin/server_processing.php',
      type: 'POST',
      data: function (d) {
        d.gender = $('#genderFilter').val();
      }
    },
    columns: [
      { data: 'id' },
      { data: 'first_name' },
      { data: 'last_name' },
      { data: 'email' },
      { data: 'position' },
      { data: 'gender' }
    ]
  });

  $('#genderFilter').on('change', function () {
    table.ajax.reload();
  });
});

$('#example').DataTable({
  processing: true,
  serverSide: true,
  serverMethod: 'post',
  ajax: 'server_processing.php',
  columns: [
    { data: 'id' },
    { data: 'first_name' },
    { data: 'last_name' },
    { data: 'email' },
    { data: 'position' },
    {
      data: 'id',
      render: function(data, type, row) {
        return `
          <a href="edit.php?id=${data}" class="btn-edit">✏️</a>
          <a href="delete.php?id=${data}" class="btn-delete" onclick="return confirm('ลบข้อมูลนี้?')">🗑️</a>
        `;
      }
    }
  ]
});

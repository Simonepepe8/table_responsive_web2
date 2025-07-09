let table;

$(document).ready(function() {
  table = $('#employeeTable').DataTable({
    ajax: 'fetch.php',
    columns: [
      { data: 'id' },
      { data: 'first_name' },
      { data: 'last_name' },
      { data: 'email' },
      { data: 'position' },
      { data: 'gender' },
      {
        data: null,
        render: function(data) {
          return `<button onclick="editRow(${data.id})">Edit</button> 
                  <button onclick="deleteRow(${data.id})">Delete</button>`;
        }
      }
    ]
  });

  $('#crudForm').submit(function(e) {
    e.preventDefault();
    const formData = $(this).serialize();
    const id = $('#empId').val();
    const type = id ? 'edit' : 'add';
    $.post('save.php', formData, function(response) {
      closePopup();
      table.ajax.reload();
      try {
        const res = JSON.parse(response);
        showAlertByType(type, res);
      } catch (e) {
        showAlertByType('default', {});
      }
    });
  });
});

function openPopup(mode, data = {}) {
  $('#overlay').show();
  $('#crudPopup').show();
  $('#popupTitle').text(mode === 'add' ? 'Add Employee' : 'Edit Employee');
  $('#crudForm')[0].reset();
  if (mode === 'edit') {
    $('#empId').val(data.id);
    $('[name="first_name"]').val(data.first_name);
    $('[name="last_name"]').val(data.last_name);
    $('[name="email"]').val(data.email);
    $('[name="position"]').val(data.position);
    $('[name="gender"]').val(data.gender);
  }
}

function closePopup() {
  $('#crudPopup').hide();
  $('#overlay').hide();
}

function closeAlert() {
  $('#alertBox').fadeOut();
}

function editRow(id) {
  $.getJSON('get.php', { id: id }, function(data) {
    openPopup('edit', data);
  });
}

function deleteRow(id) {
  if (confirm('ต้องการลบข้อมูลนี้ใช่หรือไม่?')) {
    $.getJSON('get.php', { id: id }, function(userData) {
      $.post('delete.php', { id: id }, function(response) {
        table.ajax.reload();
        showAlertByType('delete', userData);
      });
    });
  }
}

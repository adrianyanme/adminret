<?php
session_start();
include "functions.php";
$response_data = getUserData();
if (isset($response_data['error'])) {
    $error_message = $response_data['error'];
} else {
    $created_at = date('Y-m-d', strtotime($response_data['created_at']));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | User Data</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
</head>
<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">

  <?php include "navbar.php"; ?>
  <?php include "sidebar.php"; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
          <div class="container-fluid">
              <div class="row mb-2">
                  <div class="col-sm-6">
                      <h1 class="m-0">Schedules</h1>
                  </div>
                  <div class="col-sm-6">
                      <button class="btn btn-primary float-right" data-toggle="modal" data-target="#addScheduleModal">Add Schedule</button>
                  </div>
              </div>
          </div>
      </div>
      <!-- Main content -->
      <div class="content">
          <div class="container-fluid">
              <!-- DataTables -->
              <div class="card">
                  <div class="card-header">
                      <h3 class="card-title">Schedule List</h3>
                  </div>
                  <div class="card-body">
                      <table id="scheduleTable" class="table table-bordered table-striped">
                          <thead>
                              <tr>
                                  <th>ID</th>
                                  <th>Hearing Number</th>
                                  <th>Agenda</th>
                                  <th>Hearing Time</th>
                                  <th>Actions</th>
                              </tr>
                          </thead>
                          <tbody>
                          </tbody>
                      </table>
                  </div>
              </div>
          </div>
      </div>
  </div>

  <?php include "footer.php"; ?>

</div>

<!-- Modal for Add Schedule -->
<div class="modal fade" id="addScheduleModal" tabindex="-1" role="dialog" aria-labelledby="addScheduleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addScheduleModalLabel">Add Schedule</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="addScheduleForm">
          <div class="form-group">
            <label for="hearing_number">Hearing Number</label>
            <input type="text" class="form-control" id="hearing_number" name="hearing_number" required>
          </div>
          <div class="form-group">
            <label for="agenda">Agenda</label>
            <input type="text" class="form-control" id="agenda" name="agenda" required>
          </div>
          <div class="form-group">
            <label for="hearing_time">Hearing Time</label>
            <input type="text" class="form-control datetimepicker-input" id="hearing_time" name="hearing_time" data-toggle="datetimepicker" data-target="#hearing_time" required>
          </div>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>
<!-- DataTables  & Plugins -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="plugins/jszip/jszip.min.js"></script>
<script src="plugins/pdfmake/pdfmake.min.js"></script>
<script src="plugins/pdfmake/vfs_fonts.js"></script>
<script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- Date Picker -->
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>

<script>
$(document).ready(function() {
    // Initialize DataTable
    var table = $('#scheduleTable').DataTable({
        "ajax": {
            "url": "http://143.198.218.9:30000/api/schedules",
            "type": "GET",
            "beforeSend": function(xhr) {
                xhr.setRequestHeader('Authorization', 'Bearer <?= $_SESSION['token'] ?>');
            },
            "dataSrc": ""
        },
        "columns": [
            { "data": "id" },
            { "data": "hearing_number" },
            { "data": "agenda" },
            { 
                "data": "hearing_time",
                "render": function(data, type, row) {
                    return new Date(data).toLocaleString();
                }
            },
            {
                "data": null,
                "render": function(data, type, row) {
                    return `
                        <button class="btn btn-danger btn-sm delete-schedule-btn" data-id="${row.id}">Delete</button>
                    `;
                }
            }
        ]
    });

    // Initialize Date Picker
    $('#hearing_time').daterangepicker({
        singleDatePicker: true,
        timePicker: true,
        locale: {
            format: 'YYYY-MM-DD HH:mm:ss'
        }
    });

    // Handle Delete Schedule
    $('#scheduleTable tbody').on('click', '.delete-schedule-btn', function() {
        var scheduleId = $(this).data('id');
        if (confirm('Are you sure you want to delete this schedule?')) {
            $.ajax({
                url: `http://143.198.218.9:30000/api/schedules/${scheduleId}`,
                type: 'DELETE',
                headers: {
                    'Authorization': 'Bearer <?= $_SESSION['token'] ?>'
                },
                success: function(response) {
                    table.ajax.reload();
                    alert('Schedule berhasil dihapus.');
                },
                error: function(xhr, status, error) {
                    console.error('Error:', xhr.responseText);
                    alert('Gagal menghapus schedule. Error: ' + xhr.responseText);
                }
            });
        }
    });

    // Handle Add Schedule
    $('#addScheduleForm').on('submit', function(e) {
        e.preventDefault();
        var formData = {
            hearing_number: $('#hearing_number').val(),
            agenda: $('#agenda').val(),
            hearing_time: $('#hearing_time').val()
        };
        $.ajax({
            url: 'http://143.198.218.9:30000/api/schedules',
            type: 'POST',
            headers: {
                'Authorization': 'Bearer <?= $_SESSION['token'] ?>'
            },
            contentType: 'application/json',
            data: JSON.stringify(formData),
            success: function(response) {
                $('#addScheduleModal').modal('hide');
                table.ajax.reload();
                alert('Schedule berhasil ditambahkan.');
            },
            error: function(xhr, status, error) {
                console.error('Error:', xhr.responseText);
                alert('Gagal menambahkan schedule. Error: ' + xhr.responseText);
            }
        });
    });
});
</script>
</body>
</html>
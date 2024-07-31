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
                      <h1 class="m-0">User Data</h1>
                  </div>
              </div>
          </div>
      </div>
      <!-- Main content -->
      <div class="content">
          <div class="container-fluid">
              <!-- Your page content goes here -->
              <?php if (isset($response_data)): ?>
                  <div class="card">
                      <div class="card-header">
                          <h3 class="card-title">User Information</h3>
                      </div>
                      <div class="card-body">
                          <p>Username: <?= htmlspecialchars($response_data['username']) ?></p>
                          <p>Role: <?= htmlspecialchars($response_data['role']) ?></p>
                          <p>Created At: <?= htmlspecialchars($created_at) ?></p>
                      </div>
                  </div>
              <?php else: ?>
                  <div class="alert alert-danger" role="alert">
                      <?= htmlspecialchars($error_message) ?>
                  </div>
              <?php endif; ?>

              <!-- DataTables -->
              <div class="card">
                  <div class="card-header">
                      <h3 class="card-title">User List</h3>
                  </div>
                  <div class="card-body">
                      <table id="userTable" class="table table-bordered table-striped">
                          <thead>
                              <tr>
                                  <th>ID</th>
                                  <th>Email</th>
                                  <th>Username</th>
                                  <th>First Name</th>
                                  <th>Last Name</th>
                                  <th>Role</th>
                                  <th>Profile Image</th>
                                  <th>NIK</th>
                                  <th>KTP Image</th>
                                  <th>Verified</th>
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

<script>
$(document).ready(function() {
    var table = $('#userTable').DataTable({
        "ajax": {
            "url": "http://143.198.218.9/backend/api/users",
            "type": "GET",
            "beforeSend": function(xhr) {
                xhr.setRequestHeader('Authorization', 'Bearer <?= $_SESSION['token'] ?>');
            },
            "dataSrc": "data"
        },
        "columns": [
            { "data": "id" },
            { "data": "email" },
            { "data": "username" },
            { "data": "firstname" },
            { "data": "lastname" },
            { "data": "role" },
            { 
                "data": "profileimg",
                "render": function(data, type, row) {
                    return '<img src="http://143.198.218.9/backend/storage/profileimg/' + data + '" alt="Profile Image" class="img-fluid img-thumbnail" width="50">';
                }
            },
            { "data": "nik" },
            {
                "data": "ktp_image",
                "render" : function(data,type,row){
                    return '<img src="http://143.198.218.9/backend/storage/ktpimage/' + data + '" alt="KTP Image" class="img-fluid img-thumbnail" width="50">';
                }
            },
            { "data": "verified" },
            {
                "data": null,
                "render": function(data, type, row) {
                    return `
                        <button class="btn btn-success btn-sm activate-btn" data-id="${row.id}">Activate</button>
                        <button class="btn btn-danger btn-sm deactivate-btn" data-id="${row.id}">Deactivate</button>
                    `;
                }
            }
        ]
    });

    $('#userTable tbody').on('click', '.activate-btn', function() {
        var userId = $(this).data('id');
        updateUserStatus(userId, 'Yes');
    });

    $('#userTable tbody').on('click', '.deactivate-btn', function() {
        var userId = $(this).data('id');
        updateUserStatus(userId, 'No');
    });

    function updateUserStatus(userId, status) {
        $.ajax({
            url: `http://143.198.218.9/backend/api/users/${userId}`,
            type: 'POST',
            headers: {
                'Authorization': 'Bearer <?= $_SESSION['token'] ?>',
                'Content-Type': 'application/json'
            },
            data: JSON.stringify({ verified: status }),
            success: function(response) {
                table.ajax.reload();
                alert('User status updated successfully.');
            },
            error: function(xhr, status, error) {
                console.error('Error:', xhr.responseText);
                alert('Failed to update user status. Error: ' + xhr.responseText);
            }
        });
    }
});
</script>
</body>
</html>
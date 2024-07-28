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
                      <h1 class="m-0">Pos Bantuan Hukum</h1>
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
                      <h3 class="card-title">Pos Bantuan Hukum List</h3>
                  </div>
                  <div class="card-body">
                      <table id="posbantuanhukumTable" class="table table-bordered table-striped">
                          <thead>
                              <tr>
                                  <th>ID</th>
                                  <th>Nama Lengkap</th>
                                  <th>No HP</th>
                                  <th>Email</th>
                                  <th>Deskripsi</th>
                                  <th>Surat Gugatan</th>
                                  <th>Surat Keterangan Tidak Mampu</th>
                                  <th>Author</th>
                                  <th>Created At</th>
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
    // Initialize DataTable
    var table = $('#posbantuanhukumTable').DataTable({
        "ajax": {
            "url": "http://143.198.218.9:8000/api/posbantuanhukum",
            "type": "GET",
            "beforeSend": function(xhr) {
                xhr.setRequestHeader('Authorization', 'Bearer <?= $_SESSION['token'] ?>');
            },
            "dataSrc": "data"
        },
        "columns": [
            { "data": "id" },
            { "data": "namalengkap" },
            { "data": "nohp" },
            { "data": "email" },
            { "data": "deskribsi" },
            { 
                "data": "suratgugatan",
                "render": function(data, type, row) {
                    return `<a href="http://143.198.218.9:8000/storage/suratgugatan/${data}" target="_blank">${data}</a>`;
                }
            },
            { 
                "data": "suratketerangantidakmampu",
                "render": function(data, type, row) {
                    return `<a href="http://143.198.218.9:8000/storage/suratketerangantidakmampu/${data}" target="_blank">${data}</a>`;
                }
            },
            { "data": "author" },
            { 
                "data": "created_at",
                "render": function(data, type, row) {
                    return new Date(data).toLocaleString();
                }
            }
        ]
    });
});
</script>
</body>
</html>
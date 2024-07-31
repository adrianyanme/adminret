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
                      <h1 class="m-0">Streaming</h1>
                  </div>
                  <div class="col-sm-6">
                      <button class="btn btn-primary float-right" data-toggle="modal" data-target="#addStreamModal">Add Stream</button>
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
                      <h3 class="card-title">Streaming List</h3>
                  </div>
                  <div class="card-body">
                      <table id="streamingTable" class="table table-bordered table-striped">
                          <thead>
                              <tr>
                                  <th>ID</th>
                                  <th>Thumbnail</th>
                                  <th>Judul Streaming</th>
                                  <th>Youtube Link</th>
                                  <th>Deskripsi</th>
                                  <th>Status Stream</th>
                                  <th>Author</th>
                                  <th>Comments</th>
                                  <th>Created At</th>
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

<!-- Modal for Change Status -->
<div class="modal fade" id="changeStatusModal" tabindex="-1" role="dialog" aria-labelledby="changeStatusModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="changeStatusModalLabel">Change Status</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="changeStatusForm">
          <div class="form-group">
            <label for="status_stream">Status Stream</label>
            <select class="form-control" id="status_stream" name="status_stream">
              <option value="On Air">On Air</option>
              <option value="Off Air">Off Air</option>
            </select>
          </div>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal for Add Stream -->
<div class="modal fade" id="addStreamModal" tabindex="-1" role="dialog" aria-labelledby="addStreamModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addStreamModalLabel">Add Stream</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="addStreamForm" enctype="multipart/form-data">
          <div class="form-group">
            <label for="file">Thumbnail</label>
            <input type="file" class="form-control" id="file" name="file" required>
          </div>
          <div class="form-group">
            <label for="judul_streaming">Judul Streaming</label>
            <input type="text" class="form-control" id="judul_streaming" name="judul_streaming" required>
          </div>
          <div class="form-group">
            <label for="youtube_link">Youtube Link</label>
            <input type="url" class="form-control" id="youtube_link" name="youtube_link" required>
          </div>
          <div class="form-group">
            <label for="deskribsi">Deskripsi</label>
            <textarea class="form-control" id="deskribsi" name="deskribsi" required></textarea>
          </div>
          <div class="form-group">
            <label for="status_stream_add">Status Stream</label>
            <select class="form-control" id="status_stream_add" name="status_stream">
              <option value="On Air">On Air</option>
              <option value="Off Air">Off Air</option>
            </select>
          </div>
          <button type="submit" class="btn btn-primary">Add Stream</button>
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

<script>
$(document).ready(function() {
    var table = $('#streamingTable').DataTable({
        "ajax": {
            "url": "http://143.198.218.9/backend/api/streaming",
            "type": "GET",
            "beforeSend": function(xhr) {
                xhr.setRequestHeader('Authorization', 'Bearer <?= $_SESSION['token'] ?>');
            },
            "dataSrc": "data"
        },
        "columns": [
            { "data": "id" },
            { 
                "data": "thumbnail",
                "render": function(data, type, row) {
                    return `<img src="http://143.198.218.9/backend/storage/thumbnails/${data}" alt="Thumbnail" class="img-fluid img-thumbnail" width="100">`;
                }
            },
            { "data": "judul_streaming" },
            { 
                "data": "youtube_link",
                "render": function(data, type, row) {
                    return `<a href="${data}" target="_blank">${data}</a>`;
                }
            },
            { "data": "deskribsi" },
            { "data": "status_stream" },
            { "data": "writer.username" },
            { "data": "comment_total" },
            { 
                "data": "created_at",
                "render": function(data, type, row) {
                    return new Date(data).toLocaleDateString();
                }
            },
            {
                "data": null,
                "render": function(data, type, row) {
                    return `
                        <button class="btn btn-warning btn-sm change-status-btn" data-id="${row.id}">Change Status</button>
                        <button class="btn btn-danger btn-sm delete-stream-btn" data-id="${row.id}">Delete</button>
                    `;
                }
            }
        ]
    });

    var currentStreamId;

    $('#streamingTable tbody').on('click', '.change-status-btn', function() {
        currentStreamId = $(this).data('id');
        $('#changeStatusModal').modal('show');
    });

    $('#changeStatusForm').on('submit', function(e) {
        e.preventDefault();
        var statusStream = $('#status_stream').val();
        $.ajax({
            url: `http://143.198.218.9/backend/api/streamings/${currentStreamId}/status`,
            type: 'PUT',
            headers: {
                'Authorization': 'Bearer <?= $_SESSION['token'] ?>'
            },
            contentType: 'application/json',
            data: JSON.stringify({ status_stream: statusStream }),
            success: function(response) {
                $('#changeStatusModal').modal('hide');
                table.ajax.reload();
                alert('Status stream berhasil diubah.');
            },
            error: function(xhr, status, error) {
                console.error('Error:', xhr.responseText);
                alert('Gagal mengubah status stream. Error: ' + xhr.responseText);
            }
        });
    });

    $('#streamingTable tbody').on('click', '.delete-stream-btn', function() {
        var streamId = $(this).data('id');
        if (confirm('Are you sure you want to delete this stream?')) {
            $.ajax({
                url: `http://143.198.218.9/backend/api/streamings/${streamId}`,
                type: 'DELETE',
                headers: {
                    'Authorization': 'Bearer <?= $_SESSION['token'] ?>'
                },
                success: function(response) {
                    table.ajax.reload();
                    alert('Stream berhasil dihapus.');
                },
                error: function(xhr, status, error) {
                    console.error('Error:', xhr.responseText);
                    alert('Gagal menghapus stream. Error: ' + xhr.responseText);
                }
            });
        }
    });

    $('#addStreamForm').on('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: 'http://143.198.218.9/backend/api/streaming',
            type: 'POST',
            headers: {
                'Authorization': 'Bearer <?= $_SESSION['token'] ?>'
            },
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $('#addStreamModal').modal('hide');
                table.ajax.reload();
                alert('Stream berhasil ditambahkan.');
            },
            error: function(xhr, status, error) {
                console.error('Error:', xhr.responseText);
                alert('Gagal menambahkan stream. Error: ' + xhr.responseText);
                // Log error to server
                $.ajax({
                    url: 'log_error.php',
                    type: 'POST',
                    data: { error: xhr.responseText },
                    success: function(response) {
                        console.log('Error logged to server.');
                    },
                    error: function(xhr, status, error) {
                        console.error('Failed to log error to server.');
                    }
                });
            }
        });
    });
});
</script>
</body>
</html>
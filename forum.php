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
                      <h1 class="m-0">Forum</h1>
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
                      <h3 class="card-title">Forum List</h3>
                  </div>
                  <div class="card-body">
                      <table id="forumTable" class="table table-bordered table-striped">
                          <thead>
                              <tr>
                                  <th>ID</th>
                                  <th>Title</th>
                                  <th>Content</th>
                                  <th>Tags</th>
                                  <th>Author</th>
                                  <th>Likes</th>
                                  <th>Dislikes</th>
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

<!-- Modal -->
<div class="modal fade" id="forumDetailModal" tabindex="-1" role="dialog" aria-labelledby="forumDetailModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="forumDetailModalLabel">Forum Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="forumDetailContent">
          <!-- Forum details will be loaded here -->
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-danger" id="deleteForumBtn">Delete</button>
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
    var table = $('#forumTable').DataTable({
        "ajax": {
            "url": "http://143.198.218.9:30000/api/forums",
            "type": "GET",
            "beforeSend": function(xhr) {
                xhr.setRequestHeader('Authorization', 'Bearer <?= $_SESSION['token'] ?>');
            },
            "dataSrc": "data"
        },
        "columns": [
            { "data": "id" },
            { "data": "title" },
            { "data": "content" },
            { "data": "tags" },
            { 
                "data": "writer.username",
                "render": function(data, type, row) {
                    return '<img src="' + row.writer.profileimg + '" alt="Profile Image" class="img-fluid img-thumbnail" width="50"> ' + data;
                }
            },
            { "data": "likes_count" },
            { "data": "dislikes_count" },
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
                    return `<button class="btn btn-info btn-sm view-details-btn" data-id="${row.id}">View Details</button>`;
                }
            }
        ]
    });

    var currentForumId;

    $('#forumTable tbody').on('click', '.view-details-btn', function() {
        currentForumId = $(this).data('id');
        $.ajax({
            url: `http://143.198.218.9:30000/api/forums/${currentForumId}`,
            type: 'GET',
            headers: {
                'Authorization': 'Bearer <?= $_SESSION['token'] ?>'
            },
            success: function(response) {
                var forum = response.data;
                var commentsHtml = forum.comments.map(comment => `
                    <div class="comment">
                        <img src="${comment.commentator.profileimg}" alt="Profile Image" class="img-fluid img-thumbnail" width="50">
                        <strong>${comment.commentator.username}</strong>
                        <p>${comment.comments_content}</p>
                        <small>${new Date(comment.created_at).toLocaleString()}</small>
                    </div>
                `).join('');
                var forumDetailHtml = `
                    <h3>${forum.title}</h3>
                    <p>${forum.content}</p>
                    <p><strong>Tags:</strong> ${forum.tags}</p>
                    <p><strong>Author:</strong> <img src="${forum.writer.profileimg}" alt="Profile Image" class="img-fluid img-thumbnail" width="50"> ${forum.writer.username}</p>
                    <p><strong>Likes:</strong> ${forum.likes_count}</p>
                    <p><strong>Dislikes:</strong> ${forum.dislikes_count}</p>
                    <p><strong>Comments:</strong> ${forum.comment_total}</p>
                    <p><strong>Created At:</strong> ${new Date(forum.created_at).toLocaleString()}</p>
                    <h4>Comments</h4>
                    ${commentsHtml}
                `;
                $('#forumDetailContent').html(forumDetailHtml);
                $('#forumDetailModal').modal('show');
            },
            error: function(xhr, status, error) {
                console.error('Error:', xhr.responseText);
                alert('Failed to load forum details. Error: ' + xhr.responseText);
            }
        });
    });

    $('#deleteForumBtn').on('click', function() {
        if (confirm('Are you sure you want to delete this forum?')) {
            $.ajax({
                url: `http://143.198.218.9:30000/api/forums/${currentForumId}`,
                type: 'DELETE',
                headers: {
                    'Authorization': 'Bearer <?= $_SESSION['token'] ?>'
                },
                success: function(response) {
                    $('#forumDetailModal').modal('hide');
                    table.ajax.reload();
                    alert('Forum deleted successfully.');
                },
                error: function(xhr, status, error) {
                    console.error('Error:', xhr.responseText);
                    alert('Failed to delete forum. Error: ' + xhr.responseText);
                }
            });
        }
    });
});
</script>
</body>
</html>
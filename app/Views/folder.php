<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Folder Management</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
        /* Sidebar styling */
        .sidebar {
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            background-color: #343a40;
            color: #fff;
            transition: transform 0.3s ease;
            padding: 15px;
        }

        .content {
            margin-left: 250px;
            transition: margin-left 0.3s ease;
        }

        .table-responsive {
            margin-top: 30px;
        }

        .panel {
            background-color: #fff;
            color: #343a40;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
        }

        body {
            background-color: #3e4b3c;
            color: #fff;
        }

        .panel-title {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .btn-primary {
            background-color: #ffc107;
            border-color: #ffc107;
        }

        .btn-primary:hover {
            background-color: #e0a800;
            border-color: #e0a800;
        }

        .btn-warning, .btn-danger {
            color: #fff;
        }

        .btn-warning:hover {
            background-color: #d39e00;
        }

        .btn-danger:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>

    <div class="content">
        <div class="container mt-4">
            <div class="panel">
                <h2 class="panel-title">Folder Management</h2>

                <!-- Button to Add New Folder -->
                <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#addFolderModal">Add Folder</button>
                
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th>No</th>
                                <th>Folder Name</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($jel)): ?>
                                <?php $no = 1; foreach ($jel as $item): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= esc($item->folder_name) ?></td>
                                    <td><?= esc($item->created_at) ?></td>
                                 <td>
                                  
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center">No data available</td>
                        </tr>
                    <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Folder Modal -->
    <div class="modal fade" id="addFolderModal" tabindex="-1" role="dialog" aria-labelledby="addFolderModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addFolderModalLabel">Add New Folder</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url('home/aksi_t_folder') ?>" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="folder_name">Folder Name</label>
                            <input type="text" class="form-control" id="folder_name" name="folder_name" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Folder</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function deleteFolder(id) {
            if (confirm('Are you sure you want to delete this folder?')) {
                window.location.href = 'folder_delete.php?id_folder=' + id;
            }
        }
    </script>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Table</title>
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
        }

        .sidebar.hidden {
            transform: translateX(-250px);
        }

        .content {
            margin-left: 250px;
            transition: margin-left 0.3s ease;
        }

        .content.shifted {
            margin-left: 0;
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
    </style>
</head>
<body>
    <div class="content" id="content">
        <div class="container mt-4">
            <div class="panel">
                <div class="panel-title">To-Do List</div>

                <div class="mb-3">
                    <form method="GET" action="<?= base_url('home/list') ?>">
                        <label for="deadline" class="form-label">Filter by Deadline:</label>
                        <input type="date" class="form-control" id="deadline" name="deadline" value="<?= service('request')->getVar('deadline') ?>">

                        <button type="submit" class="btn btn-primary mt-2">Apply Filter</button>
                        <a href="<?= base_url('home/list') ?>" class="btn btn-secondary mt-2">Clear Filter</a>
                    </form>
                </div>

                
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th>No</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Deadline</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($jel)): ?>
                            <?php $no = 1; foreach ($jel as $item): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= esc($item->title) ?></td>
                                <td><?= esc($item->description) ?></td>
                                <td><?= esc(ucfirst($item->status)) ?></td>
                                <td><?= esc($item->deadline) ?></td>
                            </tr>
                            <?php endforeach; ?>
                            <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center">No completed tasks available</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
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

                <!-- Button to Add New To-Do -->
                <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#addTodoModal">Add To-Do List</button>

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
                                <th>Countdown</th>
                                <th>Action 1</th>
                                <th>Action 2</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($jel)): ?>
                                <?php $no = 1; foreach ($jel as $item): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= esc($item->title) ?></td>
                                    <td><?= esc($item->description) ?></td>
                                    <td>
                                        <span class="<?= $item->status === 'pending' ? 'text-warning' : 'text-success' ?>">
                                            <?= esc(ucfirst($item->status)) ?>
                                        </span>
                                    </td>
                                    <td><?= esc($item->deadline) ?></td>
                                    <td>
                                        <span class="countdown" data-deadline="<?= $item->deadline ?>"></span>
                                    </td>
                                    <td>
                                        <!-- Star Button -->
                                        <button class="btn btn-sm btn-warning star-button" data-id="<?= $item->id_list ?>">
                                            <i class="fas fa-star"></i>
                                        </button>
                                        <a href="<?= base_url('home/mark_complete/' . $item->id_list) ?>" 
                                           class="btn btn-sm btn-success">
                                           <i class="fas fa-check"></i>
                                       </a>
                                   </td>

                                   <td>
                                    <!-- Edit Button -->
                                    <button class="btn btn-sm btn-warning" 
                                    data-toggle="modal" 
                                    data-target="#editTodoModal-<?= $item->id_list ?>">Edit</button>
                                    <a href="<?= base_url('home/h_list/' . $item->id_list) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </td>
                            </tr>

                            
                            <!-- Modal for Editing To-Do -->
                            <div class="modal fade" id="editTodoModal-<?= $item->id_list ?>" tabindex="-1" role="dialog" aria-labelledby="editTodoModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editTodoModalLabel">Edit To-Do</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="<?= base_url('home/update_t_list/' . $item->id_list) ?>" method="post">
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="title">Title</label>
                                                    <input type="text" class="form-control" id="title" name="title" value="<?= esc($item->title) ?>" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="description">Description</label>
                                                    <textarea class="form-control" id="description" name="description" rows="3" required><?= esc($item->description) ?></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label for="status">Status</label>
                                                    <select class="form-control" id="status" name="status" required>
                                                        <option value="undo" <?= $item->status === 'undo' ? 'selected' : '' ?>>Undo</option>
                                                        <option value="pending" <?= $item->status === 'pending' ? 'selected' : '' ?>>Pending</option>
                                                        <option value="complete" <?= $item->status === 'complete' ? 'selected' : '' ?>>Complete</option>
                                                        <option value="failed" <?= $item->status === 'failed' ? 'selected' : '' ?>>Failed</option>
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label for="deadline">Deadline</label>
                                                    <input type="datetime-local" class="form-control" id="deadline" name="deadline" value="<?= date('Y-m-d\TH:i', strtotime($item->deadline)) ?>" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-primary">Save Changes</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
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

<!-- Modal for Adding To-Do -->
<div class="modal fade" id="addTodoModal" tabindex="-1" role="dialog" aria-labelledby="addTodoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addTodoModalLabel">Add New To-Do</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('home/aksi_t_list') ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="deadline">Deadline</label>
                        <input type="datetime-local" class="form-control" id="deadline" name="deadline" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add To-Do</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const countdownElements = document.querySelectorAll('.countdown');

        countdownElements.forEach(function(element) {
            const deadline = new Date(element.dataset.deadline).getTime();

            function updateCountdown() {
                const now = new Date().getTime();
                const distance = deadline - now;

                if (distance > 0) {
                    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                    element.textContent = `${days}d ${hours}h ${minutes}m ${seconds}s`;
                } else {
                    element.textContent = "Expired";
                }
            }

            updateCountdown();
            setInterval(updateCountdown, 1000);
        });
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const tableBody = document.querySelector("tbody");

        document.querySelectorAll(".star-button").forEach(button => {
            button.addEventListener("click", function() {
                const row = this.closest("tr");
                const isStarred = row.dataset.starred === "true";

                if (isStarred) {
                    // Kembalikan ke posisi awal
                    row.dataset.starred = "false";
                    tableBody.appendChild(row);
                    this.classList.remove("btn-dark");
                    this.classList.add("btn-warning");
                } else {
                    // Pindahkan ke atas
                    row.dataset.starred = "true";
                    tableBody.insertBefore(row, tableBody.firstChild);
                    this.classList.remove("btn-warning");
                    this.classList.add("btn-dark");
                }
            });
        });
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const countdownElements = document.querySelectorAll('.countdown');

        countdownElements.forEach(function (element) {
            const deadline = new Date(element.dataset.deadline).getTime();
            const notificationSentKey = `notified-${element.dataset.deadline}`; // Avoid duplicate alerts

            function updateCountdown() {
                const now = new Date().getTime();
                const distance = deadline - now;

                if (distance > 0) {
                    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                    element.textContent = `${days}d ${hours}h ${minutes}m ${seconds}s`;

                    // Notify when 10 minutes before deadline
                    if (distance <= 10 * 60 * 1000 && !localStorage.getItem(notificationSentKey)) {
                        alert(`Reminder: The deadline for "${element.closest('tr').querySelector('td:nth-child(2)').textContent}" is in less than 10 minutes!`);
                        localStorage.setItem(notificationSentKey, true);
                    }
                } else {
                    element.textContent = "Expired";
                }
            }

            updateCountdown();
            setInterval(updateCountdown, 1000);
        });
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
    const countdownElements = document.querySelectorAll('.countdown');

    countdownElements.forEach(function (element) {
        const deadline = new Date(element.dataset.deadline).getTime();
        const todoId = element.closest('tr').dataset.id; // ID untuk server update

        function updateCountdown() {
            const now = new Date().getTime();
            const distance = deadline - now;

            if (distance > 0) {
                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                element.textContent = `${days}d ${hours}h ${minutes}m ${seconds}s`;
            } else {
                element.textContent = "Expired";

                // Update status ke "failed" di database
                if (todoId) {
                    fetch(`<?= base_url('home/update_status_failed') ?>/${todoId}`, {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                        },
                        body: JSON.stringify({ status: "failed" }),
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Perbarui tampilan status
                            const statusCell = element.closest('tr').querySelector('td:nth-child(4)');
                            statusCell.innerHTML = '<span class="text-danger">Failed</span>';
                        }
                    })
                    .catch(error => console.error("Error:", error));
                }
            }
        }

        updateCountdown();
        setInterval(updateCountdown, 1000);
    });
});

</script>



</body>
</html>

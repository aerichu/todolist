<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Set Logo</title>
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

        /* Styling for when the sidebar is hidden */
        .sidebar.hidden {
            transform: translateX(-250px); /* Shift sidebar to the left */
        }

        /* Content styling to shift right when sidebar is visible */
        .content {
            margin-left: 250px;
            transition: margin-left 0.3s ease;
        }

        /* Styling when sidebar is hidden */
        .content.shifted {
            margin-left: 0;
        }

        .table-responsive {
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
       

        <!-- Main content area -->
        <div class="content">
            <form id="settingForm" novalidate action="<?= base_url('home/aksietoko/')?>" method="POST" enctype="multipart/form-data">
                <div class="container">
                    <h1>Edit Toko</h1>
                    <div class="profile-info">
                        <label for="nama">Nama Toko:</label>
                        <input name="nama" type="text" class="form-control" id="nama" value="<?= isset($jes[0]->nama_toko) ? $jes[0]->nama_toko : '' ?>" required>
                    </div>
                    <div class="profile-info">
                        <label for="logo">Logo:</label>
                        <input name="foto" type="file" class="form-control" id="foto" onchange="previewImage()">
                        <input name="id" type="hidden" class="form-control" id="id" value="<?= isset($jes[0]->id_toko) ? $jes[0]->id_toko : '' ?>">

                        <!-- Check if the logo exists and display it -->
                        <?php if (isset($jes[0]->logo) && !empty($jes[0]->logo)): ?>
                            <img id="preview" src="<?= base_url('images/' . $jes[0]->logo) ?>" alt="Preview Image" class="mt-2" style="max-width: 100px;">
                        <?php else: ?>
                            <img id="preview" src="<?= base_url('images/default_logo.png') ?>" alt="Preview Image" class="mt-2" style="max-width: 100px;">
                        <?php endif; ?>
                    </div>
                    <button class="btn btn-warning btn-sm" type="submit">Save Edit</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        function previewImage() {
            const fileInput = document.getElementById('foto');
            const preview = document.getElementById('preview');
            
            if (fileInput.files && fileInput.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function (e) {
                    preview.src = e.target.result;
                }
                
                reader.readAsDataURL(fileInput.files[0]);
            }
        }
    </script>
</body>
</html>

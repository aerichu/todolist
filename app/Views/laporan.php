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
            z-index: 1000; /* Keep sidebar on top */
        }

        /* Content styling to shift right when sidebar is visible */
        .content {
            margin-left: 250px; /* Same width as sidebar */
            transition: margin-left 0.3s ease;
            padding: 20px;
        }

        .table-responsive {
            margin-top: 30px;
        }
    </style>
</head>
<body>

    <!-- Main Content -->
    <div class="content" id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <div class="row mb-4">
                    <!-- Combined Form -->
                    <div class="col-md-12 mb-3">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Generate Report</h5>
                            </div>
                            <div class="card-body">
                                <form id="reportForm" action="<?= base_url('home/generate_report') ?>" method="post">
                                    <div class="mb-3">
                                        <label for="start_date" class="form-label">Start Date:</label>
                                        <input type="date" id="start_date" name="start_date" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="end_date" class="form-label">End Date:</label>
                                        <input type="date" id="end_date" name="end_date" class="form-control" required>
                                    </div>
                                    <input type="hidden" id="report_type" name="report_type" value="">
                                    <button type="submit" class="btn btn-primary" onclick="setReportType('pdf')">Generate PDF</button>
                                    <button type="submit" class="btn btn-success" onclick="setReportType('excel')">Generate Excel</button>
                                    <button type="submit" class="btn btn-info" onclick="setReportType('window')">Generate Windows</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
    function setReportType(type) {
        document.getElementById('report_type').value = type;
    }
    </script>
</body>
</html>

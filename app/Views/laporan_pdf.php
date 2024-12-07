<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan PDF</title>
    <style>
        /* Tambahkan gaya CSS sesuai kebutuhan */
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #dddddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

    <h2>Laporan PDF</h2>
    <table>
        <thead>
            <tr>
             <th>No</th>
             <th>Title</th>
             <th>Description</th>
             <th>Status</th>
             <th>Deadline</th>
             <th>Created At</th>
             <th>Deleted At</th>
         </tr>
     </thead>
     <tbody>
        <?php foreach ($laporan as $key => $row) : ?>
        <tr>
            <td><?= $key + 1 ?></td>
            <td><?= $row->title ?></td>
            <td><?= $row->description ?></td>
            <td><?= $row->status ?></td>
            <td><?= $row->deadline ?></td>
            <td><?= $row->created_at ?></td>
            <td><?= $row->deleted_at ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
</body>
</html>

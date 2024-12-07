<?php
$conn = new mysqli('localhost', 'root', '', 'dream');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $folder_name = $conn->real_escape_string($_POST['folder_name']);
    $id_user = 1; // Ganti dengan ID user login saat ini

    $sql = "INSERT INTO folder (id_user, folder_name) VALUES ($id_user, '$folder_name')";

    if ($conn->query($sql) === TRUE) {
        header("Location: folder.php");
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

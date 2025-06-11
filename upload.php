<?php
session_start();
if (!isset($_SESSION['user']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}
include 'koneksi/db.php';
session_start(); 
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_file = $_FILES['gambar']['name'];
    $tmp_file = $_FILES['gambar']['tmp_name'];
    $folder = "img/";

    if (move_uploaded_file($tmp_file, $folder . $nama_file)) {
        $query = "UPDATE users SET gambar = '$nama_file' WHERE id = $id";
        mysqli_query($conn, $query);
        header("Location: dashboard.php");
        exit;
    } else {
        echo "Gagal upload gambar!";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Upload Gambar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container mt-5">
    <h2>Upload Gambar Mahasiswa</h2>
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="gambar" class="form-label">Pilih Gambar</label>
            <input type="file" name="gambar" id="gambar" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Upload</button>
        <a href="dashboard.php" class="btn btn-secondary">Kembali</a>
    </form>
</body>

</html>
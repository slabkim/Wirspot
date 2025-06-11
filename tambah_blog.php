<?php
session_start();
if (!isset($_SESSION['user']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}
include 'koneksi/db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = $_POST['judul'];
    $konten = $_POST['konten'];
    $gambar = '';

    if ($_FILES['gambar']['name']) {
        $gambar = basename($_FILES['gambar']['name']);
        move_uploaded_file($_FILES['gambar']['tmp_name'], "img/$gambar");
    }

    $query = "INSERT INTO blog (judul, konten, gambar) VALUES ('$judul', '$konten', '$gambar')";
    mysqli_query($conn, $query);
    header("Location: admin/kelolaBlog.php");
    exit;
}
?>
<form action="" method="post" enctype="multipart/form-data">
    <input type="text" name="judul" placeholder="Judul" required><br>
    <textarea name="konten" placeholder="Konten" required></textarea><br>
    <input type="file" name="gambar"><br>
    <button type="submit">Tambah</button>
</form>
<?php
session_start();
if (!isset($_SESSION['user']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}
include 'koneksi/db.php';
$id = $_GET['id'];
$blog = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM blog WHERE id=$id"));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = $_POST['judul'];
    $konten = $_POST['konten'];
    $status = $_POST['status'];
    $gambar = $blog['gambar'];

    if ($_FILES['gambar']['name']) {
        $gambar = basename($_FILES['gambar']['name']);
        move_uploaded_file($_FILES['gambar']['tmp_name'], "img/$gambar");
    }

    $query = "UPDATE blog SET judul='$judul', konten='$konten', gambar='$gambar', status='$status' WHERE id=$id";
    mysqli_query($conn, $query);
    header("Location: admin/kelolaBlog.php");
    exit;
}
?>
<form action="" method="post" enctype="multipart/form-data">
    <input type="text" name="judul" value="<?= $blog['judul'] ?>" required><br>
    <textarea name="konten" required><?= $blog['konten'] ?></textarea><br>
    <label for="status">Status:</label>
    <select name="status" id="status" required>
        <option value="draft" <?= $blog['status'] === 'draft' ? 'selected' : '' ?>>Draft</option>
        <option value="published" <?= $blog['status'] === 'published' ? 'selected' : '' ?>>Published</option>
    </select><br><br>
    <input type="file" name="gambar"><br>
    <button type="submit">Simpan Perubahan</button>
</form>
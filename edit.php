<?php 
include "koneksi/db.php"; 
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}

$id = $_GET['id']; 
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id=$id"));

if (isset($_POST['update'])) { 
    $username = $_POST['username']; 
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); 
    $gambar_lama = $data['gambar'];

    if (!empty($_FILES['gambar']['name'])) {
        $nama_file = $_FILES['gambar']['name'];
        $tmp_file = $_FILES['gambar']['tmp_name'];
        $folder = "img/";
        move_uploaded_file($tmp_file, $folder . $nama_file);
    } else {
        $nama_file = $gambar_lama;
    }

    $query = "UPDATE users SET username='$username', password='$password', gambar='$nama_file' WHERE id=$id";
    mysqli_query($conn, $query);
    echo "<div class='alert alert-success mt-3'>Data berhasil diupdate.</div>"; 
    $data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id=$id"));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Edit Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container mt-5">
    <h2>Edit Data Mahasiswa</h2>
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label>Username</label>
            <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($data['username']) ?>"
                required>
        </div>
        <div class="mb-3">
            <label>Password Baru</label>
            <input type="text" name="password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Gambar Saat Ini</label><br>
            <?php if ($data['gambar']): ?>
            <img src="img/<?= $data['gambar'] ?>" width="100" height="100">
            <?php else: ?>
            <p>Tidak ada gambar</p>
            <?php endif; ?>
        </div>
        <div class="mb-3">
            <label>Ganti Gambar</label>
            <input type="file" name="gambar" class="form-control">
        </div>
        <button type="submit" name="update" class="btn btn-warning">Update</button>
        <a href="admin/dashboard.php" class="btn btn-secondary">Kembali</a>
    </form>
</body>

</html>
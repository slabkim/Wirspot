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

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$duplicateError = false;

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $gambar   = $_FILES['gambar']['name'];
        $tmp      = $_FILES['gambar']['tmp_name'];
        $folder   = 'img/';
        $role     = $_POST['role'] ?? 'user';

        if (!empty($gambar)) {
            move_uploaded_file($tmp, $folder . $gambar);
        }

        $query = "INSERT INTO users (username, password, gambar, role) VALUES ('$username', '$password', '$gambar', '$role')";
        mysqli_query($conn, $query);

        header("Location: dashboard.php?success=tambah");
        exit;
    }
} catch (mysqli_sql_exception $e) {
    if (str_contains($e->getMessage(), "Duplicate entry")) {
        $duplicateError = true;
    } else {
        die("Terjadi kesalahan: " . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Tambah User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container mt-5">
    <h2>Tambah Mahasiswa/User Baru</h2>

    <?php if ($duplicateError): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        Username sudah digunakan. Silakan pilih username lain.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php endif; ?>

    <form action="" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" name="username" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Upload Gambar (opsional)</label>
            <input type="file" name="gambar" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Role</label>
            <select name="role" class="form-select" required>
                <option value="user" selected>User</option>
                <option value="admin">Admin</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Tambah</button>
        <a href="dashboard.php" class="btn btn-secondary">Kembali</a>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
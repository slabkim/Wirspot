<?php 
session_start();
if (!isset($_SESSION['user']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}
include "koneksi/db.php"; 

// Remove the second session_start() here
// session_start(); // <-- This is the line causing the issue, remove it

if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}

$id = $_GET['id']; 
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id=$id"));

    if (isset($_POST['update'])) { 
        $username = $_POST['username']; 
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT); 
        $role = $_POST['role'];
        $gambar_lama = $data['gambar'];

        if (!empty($_FILES['gambar']['name'])) {
            $nama_file = $_FILES['gambar']['name'];
            $tmp_file = $_FILES['gambar']['tmp_name'];
            $folder = "img/";
            move_uploaded_file($tmp_file, $folder . $nama_file);
        } else {
            $nama_file = $gambar_lama;
        }

        $query = "UPDATE users SET username='$username', password='$password', role='$role', gambar='$nama_file' WHERE id=$id";
        mysqli_query($conn, $query);
        echo "<div class='alert alert-success mt-3'>Data berhasil diupdate.</div>"; 
        $data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id=$id"));
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Edit Mahasiswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../styles/style.css" />
    <link rel="stylesheet" href="../dist/output.css" />
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center py-10">

    <div class="w-full max-w-lg bg-white p-8 rounded-lg shadow-lg space-y-6">
        <h2 class="text-3xl font-semibold text-center text-gray-700">Edit Data Mahasiswa</h2>

        <?php if (isset($error_message)): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Error!</strong>
            <span class="block sm:inline"><?= htmlspecialchars($error_message) ?></span>
        </div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data" class="space-y-6">
            <div>
                <label for="username" class="block text-gray-700 font-medium">Username</label>
                <input type="text" id="username" name="username" value="<?= htmlspecialchars($data['username']) ?>"
                    required
                    class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-green-500" />
            </div>

            <div>
                <label for="password" class="block text-gray-700 font-medium">Password Baru</label>
                <input type="password" id="password" name="password" required
                    class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-green-500" />
            </div>

            <div>
                <label for="role" class="block text-gray-700 font-medium">Role</label>
                <select id="role" name="role" required
                    class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-green-500">
                    <option value="user" <?= $data['role'] === 'user' ? 'selected' : '' ?>>User</option>
                    <option value="admin" <?= $data['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                </select>
            </div>

            <div>
                <label for="gambar_lama" class="block text-gray-700 font-medium">Gambar Saat Ini</label><br>
                <?php if ($data['gambar']): ?>
                <img src="img/<?= $data['gambar'] ?>" width="100" height="100" class="mb-3">
                <?php else: ?>
                <p>Tidak ada gambar</p>
                <?php endif; ?>
            </div>

            <div>
                <label for="gambar" class="block text-gray-700 font-medium">Ganti Gambar</label>
                <input type="file" name="gambar" id="gambar"
                    class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-green-500" />
            </div>

            <div class="flex justify-between items-center">
                <button type="submit" name="update"
                    class="bg-yellow-400 hover:bg-yellow-500 text-white text-sm font-semibold py-2 px-4 rounded transition">
                    Update
                </button>
                <a href="admin/dashboard.php"
                    class="text-gray-600 hover:text-gray-900 font-semibold transition underline">
                    Kembali
                </a>
            </div>
        </form>
    </div>

</body>

</html>
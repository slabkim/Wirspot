<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}
include 'koneksi/db.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
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
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../styles/style.css" />
    <link rel="stylesheet" href="../dist/output.css" />
</head>

<body class="bg-gray-100 min-h-screen flex flex-col items-center pt-10">
    <div class="w-full max-w-md bg-white p-8 rounded-lg shadow-lg">
        <h2 class="text-2xl font-semibold mb-6 text-center">Tambah Mahasiswa/User Baru</h2>

        <?php if ($duplicateError): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Error!</strong>
            <span class="block sm:inline">Username sudah digunakan. Silakan pilih username lain.</span>
        </div>
        <?php endif; ?>

        <form action="" method="POST" enctype="multipart/form-data" class="space-y-4">
            <div>
                <label class="block text-gray-700 font-medium mb-1">Username</label>
                <input type="text" name="username" required
                    class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-green-500" />
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-1">Password</label>
                <input type="password" name="password" required
                    class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-green-500" />
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-1">Upload Gambar (opsional)</label>
                <input type="file" name="gambar"
                    class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-green-500" />
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-1">Role</label>
                <select name="role" required
                    class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-green-500">
                    <option value="user" selected>User</option>
                    <option value="admin">Admin</option>
                </select>
            </div>

            <div class="flex justify-between items-center">
                <button type="submit"
                    class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition font-semibold">Tambah</button>
                <a href="admin/kelolaPengguna.php"
                    class="text-gray-600 hover:text-gray-900 font-semibold transition underline">Kembali</a>
            </div>
        </form>
    </div>
</body>

</html>
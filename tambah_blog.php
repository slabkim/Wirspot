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
    $status = $_POST['status'] ?? 'draft';
    $gambar = '';

    if ($_FILES['gambar']['name']) {
        $gambar = basename($_FILES['gambar']['name']);
        move_uploaded_file($_FILES['gambar']['tmp_name'], "img/$gambar");
    }

    $query = "INSERT INTO blog (judul, konten, gambar, status) VALUES ('$judul', '$konten', '$gambar', '$status')";
    mysqli_query($conn, $query);
    header("Location: admin/kelolaBlog.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Artikel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../styles/style.css" />
    <link rel="stylesheet" href="../dist/output.css" />
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center py-10">
    <div class="w-full max-w-lg bg-white p-8 rounded-lg shadow-md space-y-6">
        <h2 class="text-3xl font-semibold text-center text-gray-700">Tambah Artikel Baru</h2>

        <?php if (isset($duplicateError) && $duplicateError): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Error!</strong>
            <span class="block sm:inline">Username sudah digunakan. Silakan pilih username lain.</span>
        </div>
        <?php endif; ?>

        <form action="" method="post" enctype="multipart/form-data" class="space-y-6">
            <div>
                <label for="judul" class="block text-gray-700 font-medium">Judul</label>
                <input type="text" id="judul" name="judul" placeholder="Masukkan Judul Artikel" required
                    class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-green-500" />
            </div>

            <div>
                <label for="konten" class="block text-gray-700 font-medium">Konten</label>
                <textarea id="konten" name="konten" placeholder="Masukkan Konten Artikel" required
                    class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-green-500"></textarea>
            </div>

            <div>
                <label for="status" class="block text-gray-700 font-medium">Status</label>
                <select id="status" name="status" required
                    class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-green-500">
                    <option value="draft">Draft</option>
                    <option value="published">Published</option>
                </select>
            </div>

            <div>
                <label for="gambar" class="block text-gray-700 font-medium">Upload Gambar (Opsional)</label>
                <input type="file" id="gambar" name="gambar"
                    class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-green-500" />
            </div>

            <div class="flex justify-between items-center">
                <button type="submit"
                    class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition font-semibold">Tambah
                    Artikel</button>
                <a href="admin/kelolaBlog.php"
                    class="text-gray-600 hover:text-gray-900 font-semibold transition underline">Kembali</a>
            </div>
        </form>
    </div>
</body>

</html>
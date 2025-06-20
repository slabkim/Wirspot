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
        if (move_uploaded_file($_FILES['gambar']['tmp_name'], "img/$gambar")) {
            // Gambar berhasil diupload
        } else {
            $error_message = "Terjadi kesalahan saat mengunggah gambar.";
        }
    }

    $query = "UPDATE blog SET judul='$judul', konten='$konten', gambar='$gambar', status='$status' WHERE id=$id";
    if (mysqli_query($conn, $query)) {
        header("Location: admin/kelolaBlog.php");
        exit;
    } else {
        $error_message = "Terjadi kesalahan saat menyimpan data.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Artikel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../styles/style.css" />
    <link rel="stylesheet" href="../dist/output.css" />
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center py-10">

    <div class="w-full max-w-lg bg-white p-8 rounded-lg shadow-lg space-y-6">
        <h2 class="text-3xl font-semibold text-center text-gray-700">Edit Artikel</h2>

        <?php if (isset($error_message)): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Error!</strong>
            <span class="block sm:inline"><?= htmlspecialchars($error_message) ?></span>
        </div>
        <?php endif; ?>

        <form action="" method="post" enctype="multipart/form-data" class="space-y-6">
            <div>
                <label for="judul" class="block text-gray-700 font-medium">Judul</label>
                <input type="text" id="judul" name="judul" value="<?= htmlspecialchars($blog['judul']) ?>" required
                    class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-green-500" />
            </div>

            <div>
                <label for="konten" class="block text-gray-700 font-medium">Konten</label>
                <textarea id="konten" name="konten" required
                    class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-green-500"><?= htmlspecialchars($blog['konten']) ?></textarea>
            </div>

            <div>
                <label for="status" class="block text-gray-700 font-medium">Status</label>
                <select id="status" name="status" required
                    class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-green-500">
                    <option value="draft" <?= $blog['status'] === 'draft' ? 'selected' : '' ?>>Draft</option>
                    <option value="published" <?= $blog['status'] === 'published' ? 'selected' : '' ?>>Published
                    </option>
                </select>
            </div>

            <div>
                <label for="gambar" class="block text-gray-700 font-medium">Ganti Gambar</label>
                <input type="file" id="gambar" name="gambar"
                    class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-green-500" />
            </div>

            <div class="flex justify-between items-center">
                <button type="submit"
                    class="bg-yellow-400 hover:bg-yellow-500 text-white text-sm font-semibold py-2 px-4 rounded transition">Simpan
                    Perubahan</button>
                <a href="admin/kelolaBlog.php"
                    class="text-gray-600 hover:text-gray-900 font-semibold transition underline">Kembali</a>
            </div>
        </form>
    </div>

</body>

</html>
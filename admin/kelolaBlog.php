<?php
include '../koneksi/db.php';
session_start();
if (!isset($_SESSION['user']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../styles/style.css" />
    <link rel="stylesheet" href="../dist/output.css" />
</head>

<body class="bg-gray-100">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <nav class="w-1/5 min-w-[200px] bg-gray-800 border-r border-gray-200 flex flex-col pt-4">
            <div class="flex justify-center mb-6">
                <img src="../img/wirspot.png" alt="Logo" class="max-h-24 object-contain" />
            </div>
            <a href="dashboard.php" class="text-white py-3 px-6 font-medium hover:bg-gray-700 transition">Dashboard</a>
            <a href="kelolaPengguna.php" class="text-white py-3 px-6 font-medium hover:bg-gray-700 transition">Kelola
                Pengguna</a>
            <a href="kelolaBlog.php" class="text-white py-3 px-6 font-medium hover:bg-gray-700 transition">Kelola
                Blog</a>
            <a href="../logout.php"
                class="text-white py-3 px-6 font-medium hover:bg-gray-700 transition mt-auto mb-4">Logout</a>
        </nav>

        <!-- Main Content -->
        <main class="flex-1 p-6">
            <div class="flex justify-between items-center bg-white p-4 border-b border-gray-200">
                <h5 class="text-green-600 font-semibold m-0">Kelola Blog</h5>
                <span class="text-gray-500">Admin | <?php echo htmlspecialchars($_SESSION['user']); ?></span>
            </div>

            <div class="mt-6 bg-white rounded-xl shadow-md p-6">
                <h2 class="text-2xl font-semibold mb-4">Daftar Postingan Blog</h2>
                <a href="../tambah_blog.php"
                    class="inline-block bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded mb-4 transition">+
                    Tambah Blog</a>

                <form method="GET" class="mb-4">
                    <input type="text" name="search" placeholder="Cari judul atau isi blog..."
                        value="<?= htmlspecialchars($_GET['search'] ?? '') ?>"
                        class="px-3 py-2 border border-gray-300 rounded w-full md:w-1/3 focus:outline-none focus:ring-2 focus:ring-green-500" />
                </form>

                <div class="overflow-x-auto rounded-xl shadow-sm">
                    <table class="min-w-full border border-gray-300">
                        <thead class="bg-gray-800 text-white">
                            <tr>
                                <th class="py-2 px-4 border border-gray-600 text-left">No</th>
                                <th class="py-2 px-4 border border-gray-600 text-left">Judul</th>
                                <th class="py-2 px-4 border border-gray-600 text-left">Isi (Singkat)</th>
                                <th class="py-2 px-4 border border-gray-600 text-left">Gambar</th>
                                <th class="py-2 px-4 border border-gray-600 text-left">Status</th>
                                <th class="py-2 px-4 border border-gray-600 text-left">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                    $limit = 5; // posts per page
                    $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
                    $offset = ($page - 1) * $limit;

                    $search = $_GET['search'] ?? '';
                    $search_sql = "";
                    if ($search !== '') {
                        $search_escaped = mysqli_real_escape_string($conn, $search);
                        $search_sql = "WHERE judul LIKE '%$search_escaped%'";
                    }

                    // Get total posts count with search filter
                    $total_result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM blog $search_sql");
                    $total_row = mysqli_fetch_assoc($total_result);
                    $total_posts = $total_row['total'];
                    $total_pages = ceil($total_posts / $limit);

                    $no = $offset + 1;
                    $result = mysqli_query($conn, "SELECT * FROM blog $search_sql LIMIT $limit OFFSET $offset");
                    while ($row = mysqli_fetch_assoc($result)) {
                        $isiSingkat = substr(strip_tags($row['konten']), 0, 100) . '...';
                        echo "<tr class='hover:bg-gray-100'>
                                <td class='py-2 px-4 border border-gray-300'>{$no}</td>
                                <td class='py-2 px-4 border border-gray-300'>{$row['judul']}</td>
                                <td class='py-2 px-4 border border-gray-300'>{$isiSingkat}</td>
                                <td class='py-2 px-4 border border-gray-300'>
                                    <img src='../img/{$row['gambar']}' alt='Gambar' class='w-24 h-20 object-cover rounded-md' />
                                </td>
                                <td class='py-2 px-4 border border-gray-300'>{$row['status']}</td>
<td class='py-2 px-4 border border-gray-300'>
    <div class='flex space-x-2'>
        <a href='../edit_blog.php?id={$row['id']}' class='bg-yellow-400 hover:bg-yellow-500 text-white text-sm font-semibold py-1 px-3 rounded transition'>Edit</a>
        <a href='../hapus_blog.php?id={$row['id']}' onclick='return confirm(\"Hapus blog ini?\")' class='bg-red-600 hover:bg-red-700 text-white text-sm font-semibold py-1 px-3 rounded transition'>Hapus</a>
    </div>
</td>
                            </tr>";
                        $no++;
                    }
                    ?>
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    <div class="mt-4 flex justify-center space-x-2">
                        <?php if ($page > 1): ?>
                        <a href="?page=<?= $page - 1 ?>&search=<?= urlencode($search) ?>"
                            class="px-3 py-1 bg-gray-300 rounded hover:bg-gray-400">Previous</a>
                        <?php endif; ?>

                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <a href="?page=<?= $i ?>&search=<?= urlencode($search) ?>"
                            class="px-3 py-1 rounded <?= $i === $page ? 'bg-green-600 text-white' : 'bg-gray-300 hover:bg-gray-400' ?>">
                            <?= $i ?>
                        </a>
                        <?php endfor; ?>

                        <?php if ($page < $total_pages): ?>
                        <a href="?page=<?= $page + 1 ?>&search=<?= urlencode($search) ?>"
                            class="px-3 py-1 bg-gray-300 rounded hover:bg-gray-400">Next</a>
                        <?php endif; ?>
                    </div>

                </div>
            </div>
        </main>
    </div>
</body>

</html>
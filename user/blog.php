<?php
session_start();
if (!isset($_SESSION['user']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
    header("Location: ../index.php");
    exit;
}

require_once '../koneksi/db.php';

$sql = "SELECT * FROM blog WHERE status = 'published' ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <title>Blog - Wirspot</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../styles/style.css" />
    <link rel="stylesheet" href="../dist/output.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet" />
</head>

<body class="bg-gradient-to-l from-gray-900 to-gray-800 flex flex-col min-h-screen">
    <?php include 'include/navbar.php'; ?>

    <main class="max-w-7xl mx-auto px-4 py-10 flex-grow">
        <h1 class="text-4xl font-bold text-green-500 mb-8 text-center">Semua Blog</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <div
                class="bg-gray-900 text-white border border-green-400 rounded-2xl shadow-md hover:scale-105 hover:shadow-xl transition-transform duration-300 flex flex-col">
                <?php if (!empty($row['gambar'])): ?>
                <img src="../img/<?php echo htmlspecialchars($row['gambar']); ?>" alt="Blog Gambar"
                    class="rounded-t-2xl h-56 w-full object-cover" />
                <?php else: ?>
                <div
                    class="rounded-t-2xl h-56 w-full bg-gray-800 flex items-center justify-center text-green-300 text-6xl">
                    <i class="bi bi-image"></i>
                </div>
                <?php endif; ?>
                <div class="p-6 flex-1 flex flex-col">
                    <h5 class="text-2xl font-semibold mb-3 leading-tight"><?php echo htmlspecialchars($row['judul']); ?>
                    </h5>
                    <p class="flex-1 text-gray-300 leading-relaxed mb-4">
                        <?php
                                $isiSingkat = substr(strip_tags($row['konten']), 0, 100) . '...';
                                echo htmlspecialchars($isiSingkat);
                                ?>
                    </p>
                    <a href="blog-detail.php?id=<?php echo $row['id']; ?>"
                        class="mt-auto inline-block py-2 rounded bg-green-600 text-white hover:bg-green-700 text-sm transition text-center font-semibold shadow-md">
                        Baca Selengkapnya
                    </a>
                </div>
                <div class="border-t border-green-400 text-xs text-gray-400 px-6 py-3 rounded-b-2xl">
                    Dipublikasikan: <?php echo date('d M Y', strtotime($row['created_at'])); ?>
                </div>
            </div>
            <?php endwhile; ?>
            <?php else: ?>
            <div class="col-span-3 text-center text-gray-500 py-16">
                Belum ada blog yang dipublikasikan.
            </div>
            <?php endif; ?>
        </div>
    </main>

    <?php include 'include/footer.php'; ?>
</body>

</html>

<?php mysqli_close($conn); ?>
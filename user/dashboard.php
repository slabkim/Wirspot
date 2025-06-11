<?php
session_start();
if (!isset($_SESSION['user']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
    header("Location: ../index.php");
    exit;
}require_once '../koneksi/db.php';
$sql = "SELECT * FROM blog ORDER BY created_at DESC LIMIT 12";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>User Dashboard - Wirspot Blog</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-br from-blue-50 via-white to-purple-50 min-h-screen">
    <!-- Navbar -->
    <nav class="bg-white shadow">
        <div class="max-w-6xl mx-auto px-4 flex justify-between items-center h-16">
            <div class="flex items-center">
                <span class="text-2xl font-bold text-blue-700">Wirspot Blog</span>
            </div>
            <div>
                <span class="mr-4 text-gray-700">Halo, <?php echo htmlspecialchars($_SESSION['user']); ?></span>
                <a href="../logout.php"
                    class="inline-block px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700 transition">Logout</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="py-12 bg-blue-700 text-white text-center">
        <h2 class="text-3xl md:text-5xl font-bold mb-3">Blog Terbaru dari Admin</h2>
        <p class="max-w-2xl mx-auto text-lg">Baca dan ikuti perkembangan terbaru seputar teknologi, coding, dan info
            seru lainnya.</p>
    </section>

    <!-- Blog List -->
    <main class="max-w-6xl mx-auto px-4 py-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
            <?php if(mysqli_num_rows($result) > 0): ?>
            <?php while($row = mysqli_fetch_assoc($result)): ?>
            <div class="bg-white rounded-xl shadow hover:shadow-lg transition overflow-hidden flex flex-col">
                <?php if (!empty($row['gambar'])): ?>
                <img src="../img/<?php echo htmlspecialchars($row['gambar']); ?>" alt="Blog Gambar"
                    class="h-48 w-full object-cover" />
                <?php else: ?>
                <div class="h-48 w-full bg-gray-200 flex items-center justify-center text-gray-400 text-5xl">
                    <span><i class="fa fa-image"></i></span>
                </div>
                <?php endif; ?>
                <div class="p-5 flex-1 flex flex-col">
                    <h3 class="text-lg font-bold text-blue-700 mb-2 line-clamp-2">
                        <?php echo htmlspecialchars($row['judul']); ?>
                    </h3>
                    <div class="text-xs text-gray-500 mb-2">
                        <?php echo date('d M Y H:i', strtotime($row['created_at'])); ?>
                    </div>
                    <p class="text-gray-700 line-clamp-3 flex-1">
                        <?php
                                $desksingkat = strip_tags($row['desksingkat']);
                                echo htmlspecialchars(mb_strimwidth($desksingkat, 0, 120, "..."));
                            ?>
                    </p>
                    <a href="blog-detail.php?id=<?php echo $row['id']; ?>"
                        class="mt-4 inline-block px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700 text-sm transition text-center w-full font-medium">
                        Baca Selengkapnya
                    </a>
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

    <footer class="fixed bottom-0 left-0 w-full bg-gray-900 text-gray-200 py-8 text-center shadow">
        <div class="text-sm">© <?php echo date('Y'); ?> Wirspot Blog. All rights reserved.</div>
    </footer>
</body>

</html>
<?php mysqli_close($conn); ?>
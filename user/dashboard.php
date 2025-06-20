<?php
session_start();
if (!isset($_SESSION['user']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
    header("Location: ../index.php");
    exit;
}
require_once '../koneksi/db.php';
$search = '';
if (isset($_GET['search'])) {
    $search = mysqli_real_escape_string($conn, $_GET['search']);
}

if ($search !== '') {
    $sql = "SELECT * FROM blog WHERE status = 'published' AND (judul LIKE '%$search%' OR konten LIKE '%$search%') ORDER BY created_at DESC LIMIT 12";
} else {
    $sql = "SELECT * FROM blog WHERE status = 'published' ORDER BY created_at DESC LIMIT 12";
}
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>User Dashboard - Wirspot</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../styles/style.css" />
    <link rel="stylesheet" href="../dist/output.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="bg-gradient-to-l from-gray-900 to-gray-800 min-h-screen flex flex-col">

    <!-- Navbar -->
    <?php include 'include/navbar.php'; ?>

    <!-- Banner -->
    <div class="w-full flex flex-col justify-center items-center text-center relative"
        style="background-image: url('https://www.unila.ac.id/wp-content/uploads/2023/09/WhatsApp-Image-2023-09-14-at-19.32.04-1536x1152.jpeg'); background-size: cover; background-position: center; height: 70vh;">
        <div class="absolute inset-0 bg-black bg-opacity-50"></div>
        <div class="relative z-10 py-28">
            <h4 class="text-2xl md:text-3xl text-white font-semibold mb-2 drop-shadow">Selamat Datang di Wirspot</h4>
            <h3 class="text-5xl md:text-7xl font-bold text-white mb-6 drop-shadow">Ayo Mulai</h3>
            <a href="#blog">
                <button type="button"
                    class="bg-red-600 hover:bg-red-700 transition text-white text-lg font-bold px-10 py-3 rounded-lg shadow-lg">
                    Mulai
                </button>
            </a>
        </div>
    </div>

    <!-- Artikel Terbaru (Dinamis dari Database) -->
    <section id="blog" class="py-10 bg-gray-950">
        <div class="container mx-auto px-4">
            <h2 class="mb-8 text-center text-3xl md:text-4xl font-bold" style="color:#2bff59;">Artikel Terbaru</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php if(mysqli_num_rows($result) > 0): ?>
                <?php while($row = mysqli_fetch_assoc($result)): ?>
                <div
                    class="bg-gray-900 text-white border border-green-400 rounded-2xl shadow-md hover:scale-105 hover:shadow-xl transition-transform duration-300 h-full flex flex-col">
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
                        <h5 class="text-2xl font-semibold mb-3 leading-tight">
                            <?php echo htmlspecialchars($row['judul']); ?></h5>
                        <p class="flex-1 text-gray-300 leading-relaxed mb-4">
                            <?php
                            $isiSingkat = substr(strip_tags($row['konten']), 0, 100) . '...';
                            echo htmlspecialchars(string: $isiSingkat);
                            ?>
                        </p>
                    </div>
                    <div class="border-t border-green-400 text-xs text-gray-400 px-6 py-3 rounded-b-2xl">
                        Dipublikasikan: <?php echo date('d M Y', strtotime($row['created_at'])); ?>
                    </div>
                    <a href="blog-detail.php?id=<?php echo $row['id']; ?>"
                        class="mx-2 mb-6 mt-3 inline-block  py-2 rounded bg-green-600 text-white hover:bg-green-700 text-sm transition text-center w-25 font-semibold shadow-md">
                        Baca Selengkapnya
                    </a>
                </div>
                <?php endwhile; ?>
                <?php else: ?>
                <div class="col-span-3 text-center text-gray-500 py-16">
                    Belum ada blog yang dipublikasikan.
                </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include 'include/footer.php'; ?>
</body>

</html>
<?php mysqli_close($conn); ?>
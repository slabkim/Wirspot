<?php
session_start();
if (!isset($_SESSION['user']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
    header("Location: ../index.php");
    exit;
}
require_once '../koneksi/db.php';
$sql = "SELECT * FROM blog ORDER BY created_at DESC LIMIT 12";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>User Dashboard - Wirspot</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="bg-gradient-to-l from-gray-900 to-gray-800 min-h-screen flex flex-col">

    <!-- Navbar -->
    <nav class="bg-gray-900 shadow-lg">
        <div class="max-w-7xl mx-auto flex items-center justify-between px-4 py-5">
            <a href="#" class="flex items-center gap-3">
                <img src="wirspot.png" alt="Logo"
                    class="w-12 h-12 object-contain rounded-full border-2 border-green-400">
                <span class="text-white text-2xl font-bold tracking-wide">Wirspot</span>
            </a>
            <div class="flex flex-wrap items-center gap-4">
                <div class="flex gap-2">
                    <a href="blog.html" class="text-white hover:text-green-400 transition font-medium px-2">Blog</a>
                    <a href="#" class="text-white hover:text-green-400 transition font-medium px-2">Review</a>
                    <a href="profile.html"
                        class="text-white hover:text-green-400 transition font-medium px-2">Profile</a>
                </div>
                <form class="flex" role="search" onsubmit="return false;">
                    <input type="search" placeholder="Search" aria-label="Search"
                        class="rounded-l-md border border-green-400 bg-transparent text-white px-3 py-1 focus:outline-none focus:border-green-300 placeholder-gray-400" />
                    <button type="submit"
                        class="rounded-r-md border border-green-400 bg-green-500 text-gray-900 px-4 py-1 hover:bg-green-400 transition font-semibold">Search</button>
                </form>
                <span class="ml-4 text-white font-medium hidden md:inline">Halo,
                    <?php echo htmlspecialchars($_SESSION['user']); ?></span>
                <a href="../logout.php"
                    class="ml-2 px-4 py-2 rounded bg-red-600 text-white hover:bg-red-700 transition font-semibold">Logout</a>
            </div>
        </div>
    </nav>

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
                            $desksingkat = strip_tags($row['desksingkat']);
                            echo htmlspecialchars(mb_strimwidth($desksingkat, 0, 140, "..."));
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
    <footer class="bg-gray-900 text-white py-8 mt-auto">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center px-4 gap-6">
            <div class="flex items-center gap-3 mb-4 md:mb-0">
                <div class="font-bold text-2xl md:text-3xl tracking-wide">WIRSPOT</div>
                <div class="flex gap-2">
                    <a href="#"
                        class="w-10 h-10 flex items-center justify-center border border-cyan-400 rounded-full text-cyan-400 text-lg hover:bg-cyan-400 hover:text-gray-900 transition"><i
                            class="bi bi-facebook"></i></a>
                    <a href="#"
                        class="w-10 h-10 flex items-center justify-center border border-cyan-400 rounded-full text-cyan-400 text-lg hover:bg-cyan-400 hover:text-gray-900 transition"><i
                            class="bi bi-twitter"></i></a>
                    <a href="#"
                        class="w-10 h-10 flex items-center justify-center border border-cyan-400 rounded-full text-cyan-400 text-lg hover:bg-cyan-400 hover:text-gray-900 transition"><i
                            class="bi bi-instagram"></i></a>
                    <a href="#"
                        class="w-10 h-10 flex items-center justify-center border border-cyan-400 rounded-full text-cyan-400 text-lg hover:bg-cyan-400 hover:text-gray-900 transition"><i
                            class="bi bi-youtube"></i></a>
                    <a href="#"
                        class="w-10 h-10 flex items-center justify-center border border-cyan-400 rounded-full text-cyan-400 text-lg hover:bg-cyan-400 hover:text-gray-900 transition"><i
                            class="bi bi-rss"></i></a>
                </div>
            </div>
            <div class="text-center text-gray-400 text-sm">
                <div class="mb-2 space-x-2">
                    <a href="#" class="hover:underline text-cyan-200">Terms of Use</a>|
                    <a href="#" class="hover:underline text-cyan-200">Privacy Notice</a>|
                    <a href="#" class="hover:underline text-cyan-200">Cookie Policy</a>
                </div>
                <div>
                    © 2025 <a href="#" class="hover:underline text-cyan-200">UNILA</a>, LLC. ALL RIGHTS RESERVED
                </div>
            </div>
        </div>
    </footer>
</body>

</html>
<?php mysqli_close($conn); ?>
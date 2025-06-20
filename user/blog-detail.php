<?php
session_start();
if (!isset($_SESSION['user']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
    header("Location: ../index.php");
    exit;
}

require_once '../koneksi/db.php';

if (!isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit;
}

$id = intval($_GET['id']);
$sql = "SELECT * FROM blog WHERE id = $id AND status = 'published' LIMIT 1";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) === 0) {
    echo "Artikel tidak ditemukan.";
    exit;
}

$article = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <title><?php echo htmlspecialchars($article['judul']); ?> - Detail Artikel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../styles/style.css" />
    <link rel="stylesheet" href="../dist/output.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet" />
</head>

<body class="bg-gradient-to-l from-gray-900 to-gray-800 min-h-screen flex flex-col">
    <?php include 'include/navbar.php'; ?>

    <main class="flex-grow flex items-center justify-center px-4 py-10">
        <article class="bg-white/95 shadow-2xl rounded-2xl p-8 max-w-3xl w-full border border-gray-200">
            <div class="flex flex-col gap-2 mb-6">
                <h1 class="text-4xl font-extrabold text-gray-900 mb-1 leading-tight">
                    <?php echo htmlspecialchars($article['judul']); ?></h1>
                <div class="flex items-center gap-2 text-gray-500 text-xs">
                    <i class="bi bi-calendar2-week"></i>
                    <span><?php echo date('d M Y H:i', strtotime($article['created_at'])); ?></span>
                    <!-- Jika ingin menambah penulis, tambahkan di sini -->
                </div>
            </div>
            <?php if (!empty($article['gambar'])): ?>
            <div
                class="w-full h-64 overflow-hidden rounded-xl mb-8 border border-gray-200 shadow-sm hover:shadow-md transition">
                <img src="../img/<?php echo htmlspecialchars($article['gambar']); ?>" alt="Gambar Artikel"
                    class="w-full h-full object-cover transition duration-300 hover:scale-105" />
            </div>
            <?php endif; ?>
            <div class="prose prose-lg max-w-none text-gray-800 mb-4">
                <?php echo $article['konten']; ?>
            </div>
        </article>
    </main>

    <?php include 'include/footer.php'; ?>
</body>


</html>

<?php mysqli_close($conn); ?>
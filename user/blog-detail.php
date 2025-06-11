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
$sql = "SELECT * FROM blog WHERE id = $id LIMIT 1";
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
</head>

<body class="bg-gradient-to-br from-blue-50 via-white to-purple-50 min-h-screen">
    <nav class="bg-white shadow p-4 mb-8">
        <div class="max-w-6xl mx-auto flex justify-between items-center">
            <a href="dashboard.php" class="text-blue-700 font-bold text-xl">← Kembali ke Dashboard</a>
            <span class="text-gray-700">Halo, <?php echo htmlspecialchars($_SESSION['user']); ?></span>
        </div>
    </nav>

    <main class="max-w-4xl mx-auto bg-white rounded-xl shadow p-6">
        <h1 class="text-3xl font-bold text-blue-700 mb-4"><?php echo htmlspecialchars($article['judul']); ?></h1>
        <div class="text-gray-500 text-sm mb-6">
            <?php echo date('d M Y H:i', strtotime($article['created_at'])); ?>
        </div>
        <?php if (!empty($article['gambar'])): ?>
        <img src="../img/<?php echo htmlspecialchars($article['gambar']); ?>" alt="Gambar Artikel"
            class="w-full h-64 object-cover rounded mb-6" />
        <?php endif; ?>
        <div class="prose max-w-none text-gray-800">
            <?php echo $article['konten']; ?>
        </div>
    </main>
</body>

</html>

<?php mysqli_close($conn); ?>
<?php
session_start();
if (!isset($_SESSION['user']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}

include_once '../koneksi/db.php';

// Helper function to truncate text
function truncateText($text, $maxLength) {
    if (strlen($text) > $maxLength) {
        return substr($text, 0, $maxLength) . '...';
    }
    return $text;
}

// Helper function to get badge class based on status or role
function getBadgeClass($statusOrRole) {
    switch (strtolower($statusOrRole)) {
        case 'published':
            return 'bg-green-100 text-green-800';
        case 'draft':
            return 'bg-yellow-100 text-yellow-800';
        case 'pending':
            return 'bg-blue-100 text-blue-800';
        case 'active':
            return 'bg-green-100 text-green-800';
        case 'inactive':
            return 'bg-red-100 text-red-800';
        case 'admin':
            return 'bg-blue-100 text-blue-800';
        case 'user':
            return 'bg-gray-100 text-gray-800';
        default:
            return 'bg-gray-100 text-gray-800';
    }
}

// Helper function to format date
function formatDate($dateString) {
    $timestamp = strtotime($dateString);
    return date('d M Y', $timestamp);
}

// Fetch recent articles from blog table
$recent_articles = [];
$articleQuery = "SELECT id, judul, konten, created_at, views, status FROM blog ORDER BY created_at DESC LIMIT 5";
$articleResult = mysqli_query($conn, $articleQuery);
if ($articleResult) {
    while ($row = mysqli_fetch_assoc($articleResult)) {
        $row['author_name'] = 'Admin'; // Ganti jika ada kolom author_name di tabel blog
        $recent_articles[] = $row;
    }
}

// Fetch recent users from user table (ambil role dari database)
$recent_users = [];
$userQuery = "SELECT id, username, email, created_at, role FROM users ORDER BY created_at DESC LIMIT 5";
$userResult = mysqli_query($conn, $userQuery);
if ($userResult) {
    while ($row = mysqli_fetch_assoc($userResult)) {
        // Status bisa diambil dari database jika ada. Jika tidak, set manual.
        $row['status'] = 'active'; // Opsional
        $recent_users[] = $row;
    }
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Dashboard Admin</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
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
            <!-- Topbar -->
            <div class="flex justify-between items-center bg-white p-4 border-b border-gray-200">
                <h5 class="text-green-600 font-semibold m-0">Kelola Blog</h5>
                <span class="text-gray-500">Admin | <?php echo htmlspecialchars($_SESSION['user']); ?></span>
            </div>
            <!-- Content -->
            <div class="p-6">
                <!-- Statistik Cards -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                    <!-- Card 1 -->
                    <div
                        class="bg-white border-l-4 border-green-600 shadow-sm rounded-xl flex items-center p-4 min-h-[120px]">
                        <div class="flex-1">
                            <p class="text-gray-400 text-sm mb-1">Total Users</p>
                            <h4 class="text-lg font-bold mb-0">1,234</h4>
                            <p class="text-green-600 text-xs mb-0">+12% from last month</p>
                        </div>
                        <div class="bg-green-100 rounded-full p-3 ml-3">
                            <i class="fas fa-users text-green-600 text-2xl"></i>
                        </div>
                    </div>
                    <!-- Card 2 -->
                    <div
                        class="bg-white border-l-4 border-blue-600 shadow-sm rounded-xl flex items-center p-4 min-h-[120px]">
                        <div class="flex-1">
                            <p class="text-gray-400 text-sm mb-1">Total Articles</p>
                            <h4 class="text-lg font-bold mb-0">305</h4>
                            <p class="text-green-600 text-xs mb-0">+5% from last month</p>
                        </div>
                        <div class="bg-blue-100 rounded-full p-3 ml-3">
                            <i class="fas fa-file-alt text-blue-600 text-2xl"></i>
                        </div>
                    </div>
                    <!-- Card 3 -->
                    <div
                        class="bg-white border-l-4 border-yellow-500 shadow-sm rounded-xl flex items-center p-4 min-h-[120px]">
                        <div class="flex-1">
                            <p class="text-gray-400 text-sm mb-1">Total Views</p>
                            <h4 class="text-lg font-bold mb-0">7,830</h4>
                            <p class="text-green-600 text-xs mb-0">+18% from last month</p>
                        </div>
                        <div class="bg-yellow-100 rounded-full p-3 ml-3">
                            <i class="fas fa-eye text-yellow-500 text-2xl"></i>
                        </div>
                    </div>
                    <!-- Card 4 -->
                    <div
                        class="bg-white border-l-4 border-cyan-500 shadow-sm rounded-xl flex items-center p-4 min-h-[120px]">
                        <div class="flex-1">
                            <p class="text-gray-400 text-sm mb-1">Published</p>
                            <h4 class="text-lg font-bold mb-0">80</h4>
                            <p class="text-green-600 text-xs mb-0">+3% from last month</p>
                        </div>
                        <div class="bg-cyan-100 rounded-full p-3 ml-3">
                            <i class="fas fa-chart-line text-cyan-500 text-2xl"></i>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mt-8">
                    <!-- Recent Articles -->
                    <div class="bg-white rounded-lg shadow">
                        <div class="p-6 border-b border-gray-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900">Recent Articles</h3>
                                    <p class="text-sm text-gray-600">Latest blog posts and their status</p>
                                </div>
                                <a href="../tambah_blog.php"
                                    class="bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700">
                                    <i class="fas fa-plus mr-1"></i> New Article
                                </a>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="space-y-4">
                                <?php foreach ($recent_articles as $article): ?>
                                <div class="flex items-center justify-between p-4 border rounded-lg">
                                    <div class="flex-1">
                                        <h4 class="font-medium text-gray-900">
                                            <?php echo htmlspecialchars(truncateText($article['judul'], 50)); ?></h4>
                                        <p class="text-sm text-gray-600">by
                                            <?php echo htmlspecialchars($article['author_name']); ?></p>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <span
                                            class="px-2 py-1 text-xs font-medium rounded-full <?php echo getBadgeClass($article['status']); ?>">
                                            <?php echo ucfirst($article['status']); ?>
                                        </span>
                                        <span
                                            class="text-sm text-gray-500"><?php echo number_format($article['views']); ?>
                                            views</span>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Users -->
                    <div class="bg-white rounded-lg shadow">
                        <div class="p-6 border-b border-gray-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900">Recent Users</h3>
                                    <p class="text-sm text-gray-600">Newly registered users</p>
                                </div>
                                <a href="kelolaBlog.php"
                                    class="border border-gray-300 text-gray-700 px-3 py-1 rounded text-sm hover:bg-gray-50">
                                    View All
                                </a>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="space-y-4">
                                <?php foreach ($recent_users as $recent_user): ?>
                                <div class="flex items-center justify-between p-4 border rounded-lg">
                                    <div class="flex-1">
                                        <h4 class="font-medium text-gray-900">
                                            <?php echo htmlspecialchars($recent_user['username']); ?></h4>
                                        <p class="text-sm text-gray-600">
                                            <?php echo htmlspecialchars($recent_user['email']); ?></p>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <span
                                            class="px-2 py-1 text-xs font-medium rounded-full <?php echo getBadgeClass($recent_user['role']); ?>">
                                            <?php echo ucfirst($recent_user['role']); ?>
                                        </span>
                                        <span
                                            class="text-sm text-gray-500"><?php echo formatDate($recent_user['created_at']); ?></span>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-6">
                    <h6 class="text-green-700 text-lg font-semibold mb-2">Selamat datang, Admin!</h6>
                    <p class="text-gray-600">Gunakan panel di sebelah kiri untuk mengelola sistem.</p>
                </div>
            </div>

            <div class=""></div>
        </main>
    </div>
</body>

</html>
<?php mysqli_close($conn); ?>
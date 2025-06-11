<?php
session_start();
if (!isset($_SESSION['user']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit;
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
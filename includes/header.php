<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Wirspot</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../styles/style.css" />
    <link rel="stylesheet" href="../dist/output.css" />
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-gradient-to-l from-gray-900 to-gray-800 min-h-screen flex flex-col">

<!-- Navbar Tailwind -->
<nav class="bg-gray-900 shadow-lg">
  <div class="max-w-7xl mx-auto flex items-center justify-between px-4 py-5">
    <a href="dashboard.php" class="flex items-center gap-3">
      <img src="../user/wirspot.png" alt="Logo"
           class="w-12 h-12 object-contain rounded-full border-2 border-green-400">
      <span class="text-white text-2xl font-bold tracking-wide">WIRSPOT</span>
    </a>
    <div class="flex flex-wrap items-center gap-4">
      <div class="flex gap-2">
        <a href="dashboard.php" class="text-white hover:text-green-400 transition font-medium px-2">Home</a>
        <a href="blog.php" class="text-white hover:text-green-400 transition font-medium px-2">Blog</a>
        <a href="profile.php" class="text-white hover:text-green-400 transition font-medium px-2">Profile</a>
      </div>
      <form class="flex" role="search" method="GET" action="blog.php">
  <input type="search" name="search"
         value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>"
         placeholder="Search" aria-label="Search"
         class="rounded-l-md border border-green-400 bg-transparent text-white px-3 py-1 focus:outline-none focus:border-green-300 placeholder-gray-400" />
  <button type="submit"
          class="rounded-r-md border border-green-400 bg-green-500 text-gray-900 px-4 py-1 hover:bg-green-400 transition font-semibold">
    <i class="bi bi-search"></i>
  </button>
</form>
      <?php if (isset($_SESSION['user'])): ?>
        <span class="ml-4 text-white font-medium hidden md:inline">
          Halo, <?= htmlspecialchars($_SESSION['user']); ?>
        </span>
        <a href="../logout.php"
           class="ml-2 px-4 py-2 rounded bg-red-600 text-white hover:bg-red-700 transition font-semibold">Logout</a>
      <?php endif; ?>
    </div>
  </div>
</nav>

<?php if (!isset($search)) { $search = ''; } ?>
<nav class="bg-gray-900 shadow-lg">
    <div class="max-w-7xl mx-auto flex items-center justify-between px-4 py-5">
        <a href="#" class="flex items-center gap-3">
            <img src="../img/wirspot.png" alt="Logo"
                class="w-12 h-12 object-contain rounded-full border-2 border-green-400">
            <span class="text-white text-2xl font-bold tracking-wide">Wirspot</span>
        </a>
        <div class="flex flex-wrap items-center gap-4">
            <div class="flex gap-2">
                <a href="dashboard.php"
                    class="text-white hover:text-green-400 transition font-medium px-2">Dashboard</a>
                <a href="blog.php" class="text-white hover:text-green-400 transition font-medium px-2">Blog</a>
                <a href="profile.php" class="text-white hover:text-green-400 transition font-medium px-2">Profile</a>
            </div>
            <form class="flex" role="search" method="GET" action="">
                <input type="search" name="search" value="<?= htmlspecialchars($search) ?>" placeholder="Search"
                    aria-label="Search"
                    class="rounded-l-md border border-green-400 bg-transparent text-white px-3 py-1 focus:outline-none focus:border-green-300 placeholder-gray-400" />
                <button type="submit"
                    class="rounded-r-md border border-green-400 bg-green-500 text-gray-900 px-4 py-1 hover:bg-green-400 transition font-semibold">Search</button>
            </form>
        </div>
    </div>
</nav>
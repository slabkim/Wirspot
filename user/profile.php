<?php
session_start();
if (!isset($_SESSION['user']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
    header("Location: ../index.php");
    exit;
}
require_once '../koneksi/db.php';

$username = $_SESSION['user'];
$query = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
$data = mysqli_fetch_assoc($query);

include('../includes/header.php');
?>

<main class="py-12 flex-grow text-white bg-gradient-to-br from-gray-900 to-black">
  <div class="max-w-4xl mx-auto px-6">
    <h2 class="text-3xl font-bold text-green-400 mb-8 text-center border-b border-green-600 pb-4">
      Profil Pengguna
    </h2>

    <div class="bg-gray-800/80 border border-green-500 rounded-2xl shadow-2xl p-8 md:p-10 flex flex-col md:flex-row gap-8 backdrop-blur-sm">
      
      <!-- Avatar -->
      <div class="flex-shrink-0 mx-auto md:mx-0">
        <img src="https://i.pravatar.cc/150?u=<?= $data['username'] ?>" alt="Foto Profil"
             class="w-36 h-36 md:w-40 md:h-40 rounded-full border-4 border-green-500 shadow-lg transition hover:scale-105 duration-300" />
      </div>

      <!-- Info -->
      <div class="flex-1 space-y-6">
        <div>
          <label class="text-sm text-gray-400 block mb-1 uppercase tracking-wider">Username</label>
          <div class="text-xl font-semibold"><?= htmlspecialchars($data['username']) ?></div>
        </div>

        <div>
          <label class="text-sm text-gray-400 block mb-1 uppercase tracking-wider">Email</label>
          <div class="text-xl font-semibold"><?= htmlspecialchars($data['email']) ?></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label class="text-sm text-gray-400 block mb-1 uppercase tracking-wider">Role</label>
            <span class="inline-block bg-green-500 text-gray-900 font-semibold px-4 py-1 rounded-full text-sm">
              <?= htmlspecialchars($data['role']) ?>
            </span>
          </div>
          <div>
            <label class="text-sm text-gray-400 block mb-1 uppercase tracking-wider">Terdaftar Sejak</label>
            <div class="text-md font-medium"><?= date('d M Y H:i', strtotime($data['created_at'])) ?></div>
          </div>
        </div>

        <!-- Tombol -->
        <div class="pt-4">
          <a href="edit_profile.php"
             class="inline-flex items-center gap-2 px-6 py-2.5 bg-green-500 text-gray-900 font-bold rounded-lg hover:bg-green-600 transition">
            <i class="bi bi-pencil-square"></i> Ubah Profil
          </a>
        </div>
      </div>
    </div>
  </div>
</main>

<?php include('../includes/footer.php'); ?>
<?php mysqli_close($conn); ?>

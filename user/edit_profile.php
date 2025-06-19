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

// Handle POST: update data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_username = mysqli_real_escape_string($conn, $_POST['username']);
    $new_email = mysqli_real_escape_string($conn, $_POST['email']);

    if (!empty($new_username) && !empty($new_email)) {
        $update = mysqli_query($conn, "UPDATE users SET username = '$new_username', email = '$new_email' WHERE username = '$username'");

        if ($update) {
            $_SESSION['user'] = $new_username; // update session jika username diubah
            header("Location: profile.php?success=1");
            exit;
        } else {
            $error = "Gagal memperbarui profil.";
        }
    } else {
        $error = "Semua kolom harus diisi.";
    }
}

include('../includes/header.php');
?>

<main class="py-10 flex-grow text-white">
  <div class="max-w-2xl mx-auto px-6">
    <h2 class="text-3xl font-bold mb-6 border-b pb-2 border-green-500">Ubah Profil</h2>

    <?php if (isset($error)): ?>
      <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
        <?= htmlspecialchars($error) ?>
      </div>
    <?php endif; ?>

    <form method="POST" class="space-y-6 bg-gray-800 p-6 rounded-xl shadow-md border border-green-400">
      <div>
        <label for="username" class="block mb-1 text-gray-300 font-medium">Username</label>
        <input type="text" id="username" name="username" value="<?= htmlspecialchars($data['username']) ?>"
               class="w-full px-4 py-2 rounded-md bg-gray-900 border border-green-400 text-white focus:outline-none focus:ring-2 focus:ring-green-500" required>
      </div>

      <div>
        <label for="email" class="block mb-1 text-gray-300 font-medium">Email</label>
        <input type="email" id="email" name="email" value="<?= htmlspecialchars($data['email']) ?>"
               class="w-full px-4 py-2 rounded-md bg-gray-900 border border-green-400 text-white focus:outline-none focus:ring-2 focus:ring-green-500" required>
      </div>

      <div class="flex justify-between">
        <a href="profile.php" class="text-sm text-gray-400 hover:underline">← Kembali ke Profil</a>
        <button type="submit"
                class="bg-green-500 hover:bg-green-600 text-gray-900 font-bold px-6 py-2 rounded-lg transition">
          Simpan Perubahan
        </button>
      </div>
    </form>
  </div>
</main>

<?php include('../includes/footer.php'); ?>
<?php mysqli_close($conn); ?>

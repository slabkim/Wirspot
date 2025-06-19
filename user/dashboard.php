<?php
session_start();
if (!isset($_SESSION['user']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
    header("Location: ../index.php");
    exit;
}

require_once '../koneksi/db.php';
include('../includes/header.php');

// Logika pencarian
$search = '';
if (isset($_GET['search'])) {
    $search = mysqli_real_escape_string($conn, $_GET['search']);
}

if ($search !== '') {
    $sql = "SELECT * FROM blogs WHERE status = 'published' AND (judul LIKE '%$search%' OR konten LIKE '%$search%') ORDER BY created_at DESC LIMIT 12";
} else {
    $sql = "SELECT * FROM blogs WHERE status = 'published' ORDER BY created_at DESC LIMIT 12";
}
$result = mysqli_query($conn, $sql);
?>
<div class="container-fluid banner d-flex flex-column justify-content-center align-items-center text-center"
     style="background-image: url('banner.jpeg'); background-size: cover; background-position: center; height: 70vh; position: relative;">
  <div class="position-absolute top-0 bottom-0 start-0 end-0 bg-dark opacity-75"></div>
  <div class="position-relative z-1 text-white">
    <h4 class="display-6">Selamat Datang di Wirspot</h4>
    <h3 class="display-1">Ayo Mulai</h3>
    <a href="#blog">
      <button type="button" class="btn btn-danger btn-lg mt-3">Mulai</button>
    </a>
  </div>
</div>

<!-- ✅ Artikel Terbaru -->
<section id="blog" class="py-5 text-white" style="background-color:#1c1c1c;">
  <div class="container">
    <h2 class="mb-4 text-center" style="color:#2bff59;">Artikel Terbaru</h2>
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">

      <?php if (mysqli_num_rows($result) > 0): ?>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
          <div class="col">
            <div class="card h-100 bg-dark text-white border border-success rounded-4 shadow-sm">
              <?php if (!empty($row['gambar'])): ?>
                <img src="../img/<?= htmlspecialchars($row['gambar']) ?>" class="card-img-top rounded-top" alt="<?= htmlspecialchars($row['judul']) ?>">
              <?php else: ?>
                <img src="https://source.unsplash.com/600x400/?technology" class="card-img-top rounded-top" alt="Default">
              <?php endif; ?>
              <div class="card-body">
                <h5 class="card-title"><?= htmlspecialchars($row['judul']) ?></h5>
                <p class="card-text"><?= substr(strip_tags($row['konten']), 0, 100) ?>...</p>
              </div>
              <div class="card-footer border-top border-success small text-muted">
                Dipublikasikan: <?= date('d M Y', strtotime($row['created_at'])) ?>
              </div>
              <div class="text-center mb-3">
                <a href="blog-detail.php?id=<?= $row['id'] ?>" class="btn btn-success btn-sm">Baca Selengkapnya</a>
              </div>
            </div>
          </div>
        <?php endwhile; ?>
      <?php else: ?>
        <div class="col-12 text-center text-secondary py-5">Tidak ada artikel ditemukan.</div>
      <?php endif; ?>

    </div>
  </div>
</section>

<?php include('../includes/footer.php'); ?>
<?php mysqli_close($conn); ?>

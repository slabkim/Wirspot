<?php
include '../koneksi/db.php';
session_start();
if (!isset($_SESSION['user']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
    body {
        background-color: #f8f9fa;
    }

    .sidebar {
        background-color: #343a40;
        height: 100vh;
        padding-top: 1rem;
        border-right: 1px solid #dee2e6;
    }

    .sidebar a {
        text-decoration: none;
        color: #ffffff;
        display: block;
        padding: 10px 15px;
        font-weight: 500;
    }

    .sidebar a:hover {
        background-color: #495057;
        color: #fff;
    }

    .topbar {
        background-color: #ffffff;
        padding: 15px;
        border-bottom: 1px solid #dee2e6;
    }

    .content-container {
        padding: 30px;
        margin-top: 30px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        background-color: white;
        border-radius: 16px;
        color: black;
    }

    .table img {
        object-fit: cover;
        border-radius: 8px;
    }

    .btn-green {
        background-color: #28a745;
        color: white;
    }

    .btn-green:hover {
        background-color: #218838;
    }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-2 d-none d-md-block sidebar">
                <div class="text-center mb-4">
                    <img src="../img/wirspot.png" alt="Logo" class="img-fluid" style="max-height: 100px;">
                </div>
                <a href="dashboard.php">Dashboard</a>
                <a href="kelolaPengguna.php">Kelola Pengguna</a>
                <a href="#">Kelola Blog</a>
                <a href="../logout.php">Logout</a>
            </nav>


            <!-- Main Content -->
            <main class="col-md-10 ms-sm-auto">
                <div class="topbar d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-success">Kelola Blog</h5>
                    <span class="text-muted">Admin | <?php echo htmlspecialchars($_SESSION['user']); ?></span>
                </div>

                <div class="content-container">
                    <h2 class="mb-4">Daftar Postingan Blog</h2>
                    <a href="../tambah_blog.php" class="btn btn-green mb-3">+ Tambah Blog</a>

                    <div class="table-responsive rounded-4 overflow-hidden shadow-sm">
                        <table class="table table-bordered table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Judul</th>
                                    <th>Isi (Singkat)</th>
                                    <th>Gambar</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                    $no = 1;
                    $result = mysqli_query($conn, "SELECT * FROM blog");
                    while ($row = mysqli_fetch_assoc($result)) {
                        $isiSingkat = substr(strip_tags($row['konten']), 0, 100) . '...';
                        echo "<tr>
                                <td>{$no}</td>
                                <td>{$row['judul']}</td>
                                <td>{$isiSingkat}</td>
                                <td><img src='../img/{$row['gambar']}' alt='Gambar' width='100' height='80'></td>
                                <td>
                                    <a href='../edit_blog.php?id={$row['id']}' class='btn btn-warning btn-sm'>Edit</a>
                                    <a href='../hapus_blog.php?id={$row['id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Hapus blog ini?\")'>Hapus</a>
                                </td>
                            </tr>";
                        $no++;
                    }
                    ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
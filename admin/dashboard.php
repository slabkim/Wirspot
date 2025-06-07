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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="style.css" rel="stylesheet" />
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

    .content {
        padding: 20px;
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
                <a href="kelolaBlog.php">Kelola Blog</a>
                <a href="../logout.php">Logout</a>
            </nav>

            <!-- Main Content -->
            <main class="col-md-10 ms-sm-auto">
                <div class="topbar d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-success">Dashboard Admin</h5>
                    <span class="text-muted">Admin | <?php echo htmlspecialchars($_SESSION['user']); ?></span>
                </div>

                <div class="content">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="card border-success">
                                <div class="card-body">
                                    <h5 class="card-title text-success">Total Blog</h5>
                                    <p class="card-text fs-4">120</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="card border-success">
                                <div class="card-body">
                                    <h5 class="card-title text-success">Total Pengguna</h5>
                                    <p class="card-text fs-4">8</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="card border-success">
                                <div class="card-body">
                                    <h5 class="card-title text-success">Total Komentar</h5>
                                    <p class="card-text fs-4">15</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <h6 class="text-success">Selamat datang, Admin!</h6>
                        <p>Gunakan panel di sebelah kiri untuk mengelola sistem.</p>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
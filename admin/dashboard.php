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

    .stat-card {
        min-height: 120px;
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
                    <!-- Statistik Cards -->
                    <div class="row mb-4">
                        <div class="col-md-3 mb-3">
                            <div class="card border-success stat-card shadow-sm">
                                <div class="card-body d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="mb-1 text-muted">Total Users</p>
                                        <h4 class="mb-0">1,234</h4>
                                        <p class="text-success small mb-0">+12% from last month</p>
                                    </div>
                                    <div class="bg-success bg-opacity-10 rounded-circle p-3">
                                        <i class="fas fa-users text-success fs-3"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="card border-primary stat-card shadow-sm">
                                <div class="card-body d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="mb-1 text-muted">Total Articles</p>
                                        <h4 class="mb-0">305</h4>
                                        <p class="text-success small mb-0">+5% from last month</p>
                                    </div>
                                    <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                                        <i class="fas fa-file-alt text-primary fs-3"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="card border-warning stat-card shadow-sm">
                                <div class="card-body d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="mb-1 text-muted">Total Views</p>
                                        <h4 class="mb-0">7,830</h4>
                                        <p class="text-success small mb-0">+18% from last month</p>
                                    </div>
                                    <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                                        <i class="fas fa-eye text-warning fs-3"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="card border-info stat-card shadow-sm">
                                <div class="card-body d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="mb-1 text-muted">Published</p>
                                        <h4 class="mb-0">80</h4>
                                        <p class="text-success small mb-0">+3% from last month</p>
                                    </div>
                                    <div class="bg-info bg-opacity-10 rounded-circle p-3">
                                        <i class="fas fa-chart-line text-info fs-3"></i>
                                    </div>
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
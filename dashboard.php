<?php 
include 'koneksi/db.php';
session_start(); 
if (!isset($_SESSION['user'])) { 
    header("Location: index.php"); 
    exit; 
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    body {
        background-image: url('resource/bg.png');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        min-height: 100vh;
        backdrop-filter: blur(4px);
        color: #fff;
    }

    .content-container {
        background-color: rgba(0, 0, 0, 0.7);
        border-radius: 16px;
        padding: 30px;
        margin-top: 30px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
    }

    .table {
        background-color: white;
        color: black;
    }

    .navbar {
        background-color: rgba(0, 0, 0, 0.3);
    }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" style="color: #fff;" href="#">Hakim</a>
            <div class="d-flex">
                <a href="logout.php" class="btn btn-outline-light">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container content-container">

        <h2 class="text-white">Data Mahasiswa</h2>
        <a href="tambah.php" class="btn btn-primary mb-3">+ Tambah Mahasiswa</a>

        <div class="table-responsive rounded-4 overflow-hidden shadow-sm">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>USERNAME</th>
                        <th>PASS</th>
                        <th>GAMBAR</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $no = 1; 
                    $result = mysqli_query($conn, "SELECT * FROM users"); 
                    while ($row = mysqli_fetch_assoc($result)) { 
                        echo "<tr> 
                                <td>$no</td> 
                                <td>{$row['username']}</td> 
                                <td>{$row['password']}</td>
                                <td><img src='img/{$row['gambar']}' alt='Gambar' width='100' height='100'></td>
                                <td> 
                                <a href='edit.php?id={$row['id']}' class='btn btn-warning btn-sm'>Edit</a> 
                                <a href='hapus.php?id={$row['id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Hapus data ini?\")'>Hapus</a> 
                                </td> 
                            </tr>"; 
                        $no++; 
                    } 
                ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
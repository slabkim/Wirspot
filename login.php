<?php 
session_start(); 
if (isset($_SESSION['user'])) {
    if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
        header("Location: admin/dashboard.php");
    } else {
        header("Location: user/dashboard.php");
    }
    exit();
}

include 'koneksi/db.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    $query = "SELECT * FROM users WHERE username = '$username'"; 
    $result = mysqli_query($conn, $query); 

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result); 

        if (password_verify($password, $user['password'])) { 
            $_SESSION['user'] = $user['username']; 
            $_SESSION['role'] = $user['role'] ?? 'user';

            if ($_SESSION['role'] === 'admin') {
                header("Location: admin/dashboard.php");
            } else {
                header("Location: user/dashboard.php");
            }
            exit();
        }
    }
    header("Location: index.php?error=1"); 
    exit();
}
?>
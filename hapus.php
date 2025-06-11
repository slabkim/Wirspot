<?php
session_start();
if (!isset($_SESSION['user']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}
include "koneksi/db.php"; 
$id = $_GET['id']; 
mysqli_query($conn, "DELETE FROM users WHERE id=$id"); 
header("Location: ../admin/kelolaPengguna.php"); 
?>
<?php 
include "koneksi/db.php"; 
$id = $_GET['id']; 
mysqli_query($conn, "DELETE FROM users WHERE id=$id"); 
header("Location: dashboard.php"); 
?>
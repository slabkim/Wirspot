<?php
include 'koneksi/db.php';
$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM blog WHERE id = $id");
header("Location: admin/kelolaBlog.php");
exit;
?>
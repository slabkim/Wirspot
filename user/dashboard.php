<?php
session_start();
if (!isset($_SESSION['user']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
    header("Location: ../index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>User Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    body {
        background-image: url('../resource/bg.png');
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
        text-align: center;
    }

    .navbar {
        background-color: rgba(0, 0, 0, 0.3);
    }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" style="color: #fff;" href="#">User Panel</a>
            <div class="d-flex">
                <a href="../logout.php" class="btn btn-outline-light">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container content-container">
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION['user']); ?>!</h2>
        <p>This is the user dashboard.</p>
    </div>
</body>

</html>
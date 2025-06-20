<?php
session_start();
if (!isset($_SESSION['user']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
    header("Location: ../index.php");
    exit;
}

require_once '../koneksi/db.php';

// Fetch user data
$username = $_SESSION['user'];
$sql = "SELECT username, email, full_name, location, gambar FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$userData = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = $_POST['full_name'] ?? '';
    $location = $_POST['location'] ?? '';

    $folder = "../img/";

    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['name'] != "") {
        $nama_file = $_FILES['profile_image']['name'];
        $tmp_file = $_FILES['profile_image']['tmp_name'];

        if (move_uploaded_file($tmp_file, $folder . $nama_file)) {
            $query = "UPDATE users SET full_name = '$full_name', location = '$location', gambar = '$nama_file' WHERE username = '$username'";
            mysqli_query($conn, $query);
        } else {
            $error_message = "Gagal upload gambar!";
        }
    } else {
        $query = "UPDATE users SET full_name = '$full_name', location = '$location' WHERE username = '$username'";
        mysqli_query($conn, $query);
    }

    // Refresh user data after update
    $stmt->execute();
    $result = $stmt->get_result();
    $userData = $result->fetch_assoc();
}

$stmt->close();
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Profil Pengguna</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../styles/style.css" />
    <link rel="stylesheet" href="../dist/output.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet" />
</head>

<body class="bg-gradient-to-l from-gray-900 to-gray-800 text-white flex flex-col min-h-screen">
    <?php include 'include/navbar.php'; ?>
    <main class="py-5 flex-grow">
        <div class="container mx-auto px-4">
            <div class="flex flex-wrap -mx-4">
                <div class="w-full md:w-2/3 px-4 mb-6 md:mb-0">
                    <h1 class="mb-3 text-3xl font-bold">Profil Pengguna</h1>
                    <?php if (isset($error_message)): ?>
                    <div class="mb-4 p-3 bg-red-600 rounded"><?= htmlspecialchars($error_message) ?></div>
                    <?php endif; ?>
                    <form method="POST" enctype="multipart/form-data" class="space-y-4">
                        <div class="flex items-center mb-3">
                            <img src="../img/<?= htmlspecialchars($userData['gambar'] && file_exists('../img/' . $userData['gambar']) ? $userData['gambar'] : 'default.png') ?>"
                                alt="Foto Profil" class="rounded-full mr-3 object-cover w-40 h-40" />
                            <div class="flex flex-col space-y-2">
                                <input type="file" name="profile_image" accept="image/*" class="text-white" />
                                <input type="text" name="full_name"
                                    value="<?= htmlspecialchars($userData['full_name'] ?? '') ?>"
                                    placeholder="Nama Lengkap"
                                    class="bg-gray-700 text-white rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" />
                                <input type="text" name="location"
                                    value="<?= htmlspecialchars($userData['location'] ?? '') ?>" placeholder="Lokasi"
                                    class="bg-gray-700 text-white rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" />
                            </div>
                        </div>
                        <div>
                            <p class="text-gray-400 mb-1">Username: <?= htmlspecialchars($userData['username']) ?></p>
                            <p class="text-gray-400 mb-1">Email: <?= htmlspecialchars($userData['email']) ?></p>
                        </div>
                        <button type="submit"
                            class="bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-2 rounded shadow">Simpan
                            Perubahan</button>
                    </form>
                </div>
                <div class="w-full md:w-1/3 px-4">
                    <a href="../logout.php" class="text-red-600 block hover:underline"><i
                            class="bi bi-box-arrow-right mr-2"></i> Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </main>
    <?php include 'include/footer.php'; ?>
</body>

</html>
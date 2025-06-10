<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Wirspot</title>
    <script>
    window.onload = function() {
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('error') === '1') {
            alert('Login gagal. Username atau password salah.');
        }
    }
    </script>

    <style>
    body {
        background-color: black;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        min-height: 100vh;
        backdrop-filter: blur(4px);
    }

    .card {
        background-color: rgba(255, 255, 255, 0.55);
        border-radius: 16px;
        padding: 30px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.11);
    }
    </style>
</head>

<body>
    <div class="d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div class="card shadow-sm rounded-4" style="width: 100%; max-width: 400px;">
            <div class="card-body">
                <h3 class="text-center mb-4">Login</h3>
                <form method="POST" action="login.php">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" id="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" id="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Login</button>
                </form>
                <div class="mt-3 text-center">
                    <a href="register.php">Belum punya akun? Daftar di sini</a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
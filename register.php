<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <title>Register</title>
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
                <h3 class="text-center mb-4">Register</h3>
                <?php
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    // Include database connection
                    require_once 'koneksi/db.php';

                    $username = trim($_POST['username']);
                    $email = trim($_POST['email']);
                    $password = $_POST['password'];
                    $confirm_password = $_POST['confirm_password'];

                    $errors = [];

                    // Basic validation
                    if (empty($username)) {
                        $errors[] = "Username is required.";
                    }
                    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $errors[] = "Valid email is required.";
                    }
                    if (empty($password)) {
                        $errors[] = "Password is required.";
                    }
                    if ($password !== $confirm_password) {
                        $errors[] = "Passwords do not match.";
                    }

                    if (empty($errors)) {
                        // Check if username or email already exists
                        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
                        $stmt->bind_param("ss", $username, $email);
                        $stmt->execute();
                        $stmt->store_result();
                        if ($stmt->num_rows > 0) {
                            $errors[] = "Username or email already exists.";
                        }
                        $stmt->close();
                    }

                    if (empty($errors)) {
                        // Hash password
                        $password_hash = password_hash($password, PASSWORD_DEFAULT);

                        // Insert new user
                        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
                        $stmt->bind_param("sss", $username, $email, $password_hash);
                        if ($stmt->execute()) {
                            echo '<div class="alert alert-success">Registration successful. <a href="index.php">Login here</a>.</div>';
                        } else {
                            echo '<div class="alert alert-danger">Error during registration. Please try again.</div>';
                        }
                        $stmt->close();
                    }

                    if (!empty($errors)) {
                        echo '<div class="alert alert-danger"><ul>';
                        foreach ($errors as $error) {
                            echo '<li>' . htmlspecialchars($error) . '</li>';
                        }
                        echo '</ul></div>';
                    }

                    $conn->close();
                }
                ?>
                <form method="POST" action="register.php" novalidate>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" id="username" required />
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" id="email" required />
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" id="password" required />
                    </div>
                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Confirm Password</label>
                        <input type="password" name="confirm_password" class="form-control" id="confirm_password"
                            required />
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Register</button>
                </form>
                <div class="mt-3 text-center">
                    <a href="index.php">Sudah punya akun? Login di sini</a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
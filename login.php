<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Koneksi ke database
$host = "localhost";
$user = "root";
$pass = "";
$db   = "login_db";

$conn = mysqli_connect($host, $user, $pass, $db);
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Hapus semua cookies terkait login jika ada
if (isset($_COOKIE['username'])) {
    setcookie("username", "", time() - 3600, "/");
}
if (isset($_COOKIE['password'])) {
    setcookie("password", "", time() - 3600, "/");
}

// Proses login
$pesan = "";
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        $pesan = "<div class='alert alert-warning text-center mt-3'>Kolom username dan password tidak boleh kosong!</div>";
    } else {
        $query = "SELECT * FROM login WHERE username='$username' AND password='$password'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            $pesan = "<div class='alert alert-success text-center mt-3'>Selamat datang, <strong>$username</strong>! Anda berhasil login.</div>";
        } else {
            $pesan = "<div class='alert alert-danger text-center mt-3'>Login gagal. Username atau password salah.</div>";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Modern</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f0f4f8, #d9e2ec);
            height: 100vh;
            margin: 0;
        }
        .login-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 20px;
        }
        .login-card {
            display: flex;
            flex-direction: row;
            width: 100%;
            max-width: 850px;
            background-color: #fff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 3px 22px 15px rgba(0, 0, 0, 0.1);
        }
        .login-img {
            background-color: #f7fafc;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 45%;
            padding: 20px;
        }
        .login-img img {
            max-width: 100%;
            max-height: 300px;
        }
        .login-form {
            padding: 40px;
            width: 55%;
        }
        .login-form h3 {
            font-weight: 600;
            margin-bottom: 30px;
        }
        .form-label {
            font-weight: 500;
            margin-bottom: 6px;
        }
        .form-control {
            border-radius: 8px;
        }
        .btn-primary {
            background-color: #4c8ef7;
            border: none;
            border-radius: 8px;
            transition: 0.3s;
        }
        .btn-primary:hover {
            background-color: #326fd6;
        }
        @media (max-width: 768px) {
            .login-card {
                flex-direction: column;
            }
            .login-img, .login-form {
                width: 100%;
                text-align: center;
            }
            .login-form {
                padding: 30px;
            }
        }
    </style>
</head>
<body>
<div class="login-wrapper">
    <div class="login-card">
        <!-- Gambar -->
        <div class="login-img">
            <img src="logo-MAS.png" alt="Logo MAS">
        </div>

        <!-- Form -->
        <div class="login-form">
            <h3 class="text-center">Masuk ke Sistem</h3>
            <form method="POST">
                <div class="mb-3 text-start">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" required>
                </div>
                <div class="mb-3 text-start">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <button class="btn btn-primary w-100" type="submit">Login</button>
            </form>
            <?php echo $pesan; ?>
        </div>
    </div>
</div>
</body>
</html>

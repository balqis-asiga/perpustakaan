<?php
session_start();
include '../config/koneksi.php';

$error = "";

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role     = $_POST['role'];

    if ($role == "admin") {
        $query = mysqli_query($koneksi,
            "SELECT * FROM admin 
             WHERE username='$username' AND password='$password'"
        );

        if (mysqli_num_rows($query) == 1) {
            $data = mysqli_fetch_assoc($query);
            $_SESSION['admin'] = $data['username'];
            header("Location: ../admin/dashboard.php");
            exit;
        } else {
            $error = "Username atau password admin salah!";
        }

    } elseif ($role == "siswa") {
        $query = mysqli_query($koneksi,
            "SELECT * FROM anggota 
             WHERE username='$username' AND password='$password'"
        );

        if (mysqli_num_rows($query) == 1) {
            $data = mysqli_fetch_assoc($query);
            $_SESSION['siswa'] = $data['username'];
            $_SESSION['id_anggota'] = $data['id_anggota'];
            header("Location: ../siswa/dashboard.php");
            exit;
        } else {
            $error = "Username atau password siswa salah!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Perpustakaan</title>

    <!-- Bootstrap Offline -->
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/bootstrap-icons/font/bootstrap-icons.css">
</head>
<body class="bg-light">

<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow-sm" style="width: 400px;">
        <div class="card-body">
            <h4 class="text-center fw-bold mb-3">
                <i class="bi bi-book-half me-2"></i>
                Login Perpustakaan
            </h4>

            <?php if ($error != "") { ?>
                <div class="alert alert-danger py-2">
                    <i class="bi bi-exclamation-triangle me-1"></i>
                    <?= $error; ?>
                </div>
            <?php } ?>

            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Login Sebagai</label>
                    <select name="role" class="form-select" required>
                        <option value="">-- Pilih Role --</option>
                        <option value="admin">Admin</option>
                        <option value="siswa">Siswa</option>
                    </select>
                </div>

                <button type="submit" name="login" class="btn btn-primary w-100">
                    <i class="bi bi-box-arrow-in-right me-1"></i>
                    Login
                </button>
            </form>
        </div>
    </div>
</div>

<script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>

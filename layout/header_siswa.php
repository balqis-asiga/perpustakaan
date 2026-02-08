<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['siswa'])) {
    header("Location: ../auth/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Siswa Perpustakaan</title>

    <!-- Bootstrap Offline -->
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="../assets/bootstrap-icons/css/bootstrap-icons.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="dashboard.php">
      <i class="bi bi-book-half me-1"></i> Perpustakaan
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">

        <li class="nav-item">
          <a class="nav-link" href="dashboard.php">
            <i class="bi bi-house-door me-1"></i> Dashboard
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="pinjam.php">
            <i class="bi bi-journal-plus me-1"></i> Pinjam
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="kembali.php">
            <i class="bi bi-arrow-return-left me-1"></i> Kembali
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="history.php">
            <i class="bi bi-clock-history me-1"></i> Riwayat
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link text-danger" href="../auth/logout.php">
            <i class="bi bi-box-arrow-right me-1"></i> Logout
          </a>
        </li>

      </ul>
    </div>
  </div>
</nav>

<div class="container mt-4">

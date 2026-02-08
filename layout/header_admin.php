<?php
if (!isset($_SESSION['admin'])) {
    header("Location: ../auth/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin Perpustakaan</title>

    <!-- Bootstrap Offline -->
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/bootstrap-icons/fonts/bootstrap-icons.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="dashboard.php">Perpustakaan</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
        <li class="nav-item"><a class="nav-link" href="buku.php">Buku</a></li>
        <li class="nav-item"><a class="nav-link" href="anggota.php">Anggota</a></li>
        <li class="nav-item"><a class="nav-link" href="transaksi.php">Transaksi</a></li>
        <li class="nav-item">
          <a class="nav-link text-danger" href="../auth/logout.php">Logout</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="container mt-4">

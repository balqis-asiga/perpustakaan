<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../auth/login.php");
    exit;
}

include '../config/koneksi.php';
include '../layout/header_admin.php';

/* ============================
   HITUNG DATA DASHBOARD
============================ */

// Total Buku
$jumlah_buku = mysqli_num_rows(
    mysqli_query($koneksi, "SELECT * FROM buku")
);

// Total Anggota
$jumlah_anggota = mysqli_num_rows(
    mysqli_query($koneksi, "SELECT * FROM anggota")
);

// Total Buku Dipinjam
$dipinjam = mysqli_num_rows(
    mysqli_query($koneksi, "SELECT * FROM transaksi WHERE status='Dipinjam'")
);

// Total Buku Dikembalikan
$dikembalikan = mysqli_num_rows(
    mysqli_query($koneksi, "SELECT * FROM transaksi WHERE status='Dikembalikan'")
);

// Total Terlambat
$terlambat = mysqli_num_rows(
    mysqli_query($koneksi, "SELECT * FROM transaksi WHERE status='Terlambat'")
);

// Total Denda
$total_denda = mysqli_fetch_assoc(
    mysqli_query($koneksi, "SELECT SUM(denda) AS total FROM transaksi")
);
$total_denda = $total_denda['total'] ?? 0;

?>

<div class="mb-4">
    <h4 class="fw-bold">Dashboard Admin</h4>
    <p class="text-muted">Ringkasan data perpustakaan</p>
</div>

<div class="row g-4">

    <!-- TOTAL BUKU -->
    <div class="col-md-3">
        <div class="card shadow-sm border-start border-4 border-primary h-100">
            <div class="card-body">
                <h6 class="text-muted">Total Buku</h6>
                <h3 class="fw-bold"><?= $jumlah_buku; ?></h3>
            </div>
        </div>
    </div>

    <!-- TOTAL ANGGOTA -->
    <div class="col-md-3">
        <div class="card shadow-sm border-start border-4 border-success h-100">
            <div class="card-body">
                <h6 class="text-muted">Total Anggota</h6>
                <h3 class="fw-bold"><?= $jumlah_anggota; ?></h3>
            </div>
        </div>
    </div>

    <!-- DIPINJAM -->
    <div class="col-md-3">
        <div class="card shadow-sm border-start border-4 border-warning h-100">
            <div class="card-body">
                <h6 class="text-muted">Buku Dipinjam</h6>
                <h3 class="fw-bold"><?= $dipinjam; ?></h3>
            </div>
        </div>
    </div>

    <!-- DIKEMBALIKAN -->
    <div class="col-md-3">
        <div class="card shadow-sm border-start border-4 border-secondary h-100">
            <div class="card-body">
                <h6 class="text-muted">Buku Dikembalikan</h6>
                <h3 class="fw-bold"><?= $dikembalikan; ?></h3>
            </div>
        </div>
    </div>

    <!-- TERLAMBAT -->
    <div class="col-md-3">
        <div class="card shadow-sm border-start border-4 border-danger h-100">
            <div class="card-body">
                <h6 class="text-muted">Transaksi Terlambat</h6>
                <h3 class="fw-bold"><?= $terlambat; ?></h3>
            </div>
        </div>
    </div>

    <!-- TOTAL DENDA -->
    <div class="col-md-3">
        <div class="card shadow-sm border-start border-4 border-dark h-100">
            <div class="card-body">
                <h6 class="text-muted">Total Denda</h6>
                <h3 class="fw-bold text-danger">
                    Rp<?= number_format($total_denda); ?>
                </h3>
            </div>
        </div>
    </div>

</div>

<?php include '../layout/footer.php'; ?>

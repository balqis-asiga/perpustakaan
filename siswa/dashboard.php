<?php
session_start();
if (!isset($_SESSION['siswa'])) {
    header("Location: ../auth/login.php");
    exit;
}
include '../config/koneksi.php';

$id_anggota = $_SESSION['id_anggota'];

// ambil transaksi aktif (jika ada)
$pinjamAktif = mysqli_query($koneksi,
    "SELECT buku.judul, transaksi.tanggal_pinjam
     FROM transaksi
     JOIN buku ON transaksi.id_buku = buku.id_buku
     WHERE transaksi.id_anggota='$id_anggota'
     AND transaksi.status='Dipinjam'
     LIMIT 1"
);
$dataPinjam = mysqli_fetch_assoc($pinjamAktif);
?>

<?php include '../layout/header_siswa.php'; ?>

<h4 class="fw-bold mb-2">Dashboard Siswa</h4>
<p class="text-muted mb-4">Selamat datang di layanan perpustakaan</p>

<div class="row g-4 mb-4">

    <!-- STATUS PINJAMAN -->
    <div class="col-md-12">
        <div class="card shadow-sm border-start border-4 
            <?= $dataPinjam ? 'border-warning' : 'border-success'; ?>">
            <div class="card-body">
                <?php if ($dataPinjam) { ?>
                    <h5 class="fw-bold text-warning">
                        <i class="bi bi-bookmark-check me-2"></i>
                        Buku Sedang Dipinjam
                    </h5>
                    <p class="mb-1">
                        <strong>Judul:</strong> <?= $dataPinjam['judul']; ?>
                    </p>
                    <p class="mb-0">
                        <strong>Tanggal Pinjam:</strong> <?= $dataPinjam['tanggal_pinjam']; ?>
                    </p>
                <?php } else { ?>
                    <h5 class="fw-bold text-success">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        Tidak Ada Peminjaman Aktif
                    </h5>
                    <p class="mb-0">Kamu belum meminjam buku saat ini</p>
                <?php } ?>
            </div>
        </div>
    </div>

</div>

<div class="row g-4">

    <!-- PINJAM -->
    <div class="col-md-4">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <h5 class="card-title">
                    <i class="bi bi-journal-bookmark-fill text-success me-2"></i>
                    Peminjaman Buku
                </h5>
                <p class="card-text">Lihat dan pinjam buku yang tersedia</p>
                <a href="pinjam.php" class="btn btn-success w-100">
                    <i class="bi bi-plus-circle me-1"></i> Pinjam Buku
                </a>
            </div>
        </div>
    </div>

    <!-- KEMBALI -->
    <div class="col-md-4">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <h5 class="card-title">
                    <i class="bi bi-arrow-return-left text-warning me-2"></i>
                    Pengembalian Buku
                </h5>
                <p class="card-text">Kembalikan buku yang sedang dipinjam</p>
                <a href="kembali.php" class="btn btn-warning w-100">
                    <i class="bi bi-arrow-return-left me-1"></i> Kembalikan Buku
                </a>
            </div>
        </div>
    </div>

    <!-- HISTORY -->
    <div class="col-md-4">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <h5 class="card-title">
                    <i class="bi bi-clock-history text-primary me-2"></i>
                    Riwayat Peminjaman
                </h5>
                <p class="card-text">Lihat histori peminjaman buku kamu</p>
                <a href="history.php" class="btn btn-primary w-100">
                    <i class="bi bi-clock-history me-1"></i> Lihat Riwayat
                </a>
            </div>
        </div>
    </div>

</div>

<?php include '../layout/footer.php'; ?>

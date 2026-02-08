<?php
session_start();
if (!isset($_SESSION['siswa'])) {
    header("Location: ../auth/login.php");
    exit;
}
include '../config/koneksi.php';

$id_anggota = $_SESSION['id_anggota'];
?>

<?php include '../layout/header_siswa.php'; ?>

<h4 class="fw-bold mb-3">
    <i class="bi bi-clock-history me-2"></i>
    Riwayat Peminjaman Buku
</h4>

<a href="dashboard.php" class="btn btn-secondary btn-sm mb-3">
    <i class="bi bi-arrow-left"></i> Kembali
</a>

<div class="card shadow-sm">
    <div class="card-body table-responsive">

        <table class="table table-hover align-middle">
            <thead class="table-primary text-center">
                <tr>
                    <th>No</th>
                    <th>Judul Buku</th>
                    <th>Tgl Pinjam</th>
                    <th>Harus Kembali</th>
                    <th>Tgl Kembali</th>
                    <th>Status</th>
                    <th>Denda</th>
                </tr>
            </thead>

            <tbody>
            <?php
            $no = 1;
            $query = mysqli_query($koneksi,
                "SELECT buku.judul,
                        transaksi.tanggal_pinjam,
                        transaksi.tanggal_harus_kembali,
                        transaksi.tanggal_kembali,
                        transaksi.status,
                        transaksi.denda
                 FROM transaksi
                 JOIN buku ON transaksi.id_buku = buku.id_buku
                 WHERE transaksi.id_anggota='$id_anggota'
                 ORDER BY transaksi.id_transaksi DESC"
            );

            if (mysqli_num_rows($query) == 0) {
                echo '<tr>
                        <td colspan="7" class="text-center text-muted">
                            <i class="bi bi-info-circle me-1"></i>
                            Belum ada riwayat peminjaman
                        </td>
                      </tr>';
            }

            while ($row = mysqli_fetch_assoc($query)) {
            ?>
                <tr>
                    <td class="text-center"><?= $no++; ?></td>

                    <td><?= $row['judul']; ?></td>

                    <td class="text-center"><?= $row['tanggal_pinjam']; ?></td>

                    <td class="text-center">
                        <?= $row['tanggal_harus_kembali']; ?>
                    </td>

                    <td class="text-center">
                        <?= $row['tanggal_kembali'] ? $row['tanggal_kembali'] : '-' ?>
                    </td>

                    <!-- STATUS -->
                    <td class="text-center">
                        <?php if ($row['status'] == 'Dipinjam') { ?>
                            <span class="badge bg-warning text-dark">
                                <i class="bi bi-bookmark-check me-1"></i>
                                Dipinjam
                            </span>

                        <?php } elseif ($row['status'] == 'Terlambat') { ?>
                            <span class="badge bg-danger">
                                <i class="bi bi-exclamation-triangle me-1"></i>
                                Terlambat
                            </span>

                        <?php } else { ?>
                            <span class="badge bg-success">
                                <i class="bi bi-check-circle me-1"></i>
                                Dikembalikan
                            </span>
                        <?php } ?>
                    </td>

                    <!-- DENDA -->
                    <td class="text-center">
                        <?php if ($row['denda'] > 0) { ?>
                            <span class="text-danger fw-bold">
                                Rp <?= number_format($row['denda'], 0, ',', '.'); ?>
                            </span>
                        <?php } else { ?>
                            <span class="text-muted">-</span>
                        <?php } ?>
                    </td>

                </tr>
            <?php } ?>
            </tbody>
        </table>

    </div>
</div>

<?php include '../layout/footer.php'; ?>

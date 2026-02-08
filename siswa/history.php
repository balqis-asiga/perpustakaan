<?php
session_start();
if (!isset($_SESSION['siswa'])) {
    header("Location: ../auth/login.php");
    exit;
}
include '../config/koneksi.php';

$id_anggota = $_SESSION['id_anggota'];

/* ===============================
   FITUR SEARCH HISTORY
   =============================== */
$cari = isset($_GET['cari']) ? $_GET['cari'] : "";

$querySQL = "
    SELECT buku.judul,
           transaksi.tanggal_pinjam,
           transaksi.tanggal_harus_kembali,
           transaksi.tanggal_kembali,
           transaksi.status,
           transaksi.denda
    FROM transaksi
    JOIN buku ON transaksi.id_buku = buku.id_buku
    WHERE transaksi.id_anggota='$id_anggota'
";

if ($cari != "") {
    $querySQL .= " AND (buku.judul LIKE '%$cari%' 
                    OR transaksi.status LIKE '%$cari%')";
}

$querySQL .= " ORDER BY transaksi.id_transaksi DESC";

$query = mysqli_query($koneksi, $querySQL);
?>

<?php include '../layout/header_siswa.php'; ?>

<h4 class="fw-bold mb-3">
    <i class="bi bi-clock-history me-2"></i>
    Riwayat Peminjaman Buku
</h4>

<a href="dashboard.php" class="btn btn-secondary btn-sm mb-3">
    <i class="bi bi-arrow-left"></i> Kembali
</a>

<!-- FORM SEARCH -->
<form method="GET" class="d-flex mb-3">
    <input type="text" name="cari"
        class="form-control me-2"
        placeholder="Cari judul buku / status..."
        value="<?= $cari; ?>">

    <button type="submit" class="btn btn-primary">
        🔍 Cari
    </button>

    <?php if ($cari != "") { ?>
        <a href="history.php" class="btn btn-secondary ms-2">
            Reset
        </a>
    <?php } ?>
</form>


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

            if (mysqli_num_rows($query) == 0) {
                echo '<tr>
                        <td colspan="7" class="text-center text-muted">
                            Data tidak ditemukan.
                        </td>
                      </tr>';
            }

            while ($row = mysqli_fetch_assoc($query)) {
            ?>
                <tr>
                    <td class="text-center"><?= $no++; ?></td>
                    <td><?= $row['judul']; ?></td>
                    <td class="text-center"><?= $row['tanggal_pinjam']; ?></td>
                    <td class="text-center"><?= $row['tanggal_harus_kembali']; ?></td>
                    <td class="text-center">
                        <?= $row['tanggal_kembali'] ? $row['tanggal_kembali'] : '-' ?>
                    </td>

                    <td class="text-center">
                        <?php if ($row['status'] == 'Dipinjam') { ?>
                            <span class="badge bg-warning text-dark">Dipinjam</span>
                        <?php } elseif ($row['status'] == 'Terlambat') { ?>
                            <span class="badge bg-danger">Terlambat</span>
                        <?php } else { ?>
                            <span class="badge bg-success">Dikembalikan</span>
                        <?php } ?>
                    </td>

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

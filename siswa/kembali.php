<?php
session_start();
if (!isset($_SESSION['siswa'])) {
    header("Location: ../auth/login.php");
    exit;
}

include '../config/koneksi.php';

$id_anggota = $_SESSION['id_anggota'];

/* ===============================
   PROSES PENGEMBALIAN BUKU
================================ */
if (isset($_GET['kembali'])) {

    $id_transaksi = $_GET['kembali'];

    // ambil data transaksi
    $data = mysqli_fetch_assoc(mysqli_query($koneksi,
        "SELECT id_buku, tanggal_harus_kembali 
         FROM transaksi 
         WHERE id_transaksi='$id_transaksi'
         AND id_anggota='$id_anggota'"
    ));

    if ($data) {

        $id_buku = $data['id_buku'];
        $tgl_harus = $data['tanggal_harus_kembali'];
        $tgl_sekarang = date("Y-m-d");

        // hitung keterlambatan (hari)
        $selisih = (strtotime($tgl_sekarang) - strtotime($tgl_harus)) / 86400;

        $denda = 0;
        $status = "Dikembalikan";

        if ($selisih > 0) {
            $denda = $selisih * 1000; // Rp1000 per hari
            $status = "Terlambat";
        }

        // update transaksi
        mysqli_query($koneksi,
            "UPDATE transaksi SET
                tanggal_kembali = CURDATE(),
                status = '$status',
                denda = '$denda'
             WHERE id_transaksi='$id_transaksi'"
        );

        // tambah stok buku
        mysqli_query($koneksi,
            "UPDATE buku SET stok = stok + 1 
             WHERE id_buku='$id_buku'"
        );

        header("Location: kembali.php");
        exit;
    }
}
?>

<?php include '../layout/header_siswa.php'; ?>

<h4 class="fw-bold mb-3">📌 Pengembalian Buku</h4>
<a href="dashboard.php" class="btn btn-secondary btn-sm mb-3">
    ← Kembali
</a>

<div class="card shadow-sm">
    <div class="card-body table-responsive">

        <table class="table table-hover align-middle">
            <thead class="table-dark text-center">
                <tr>
                    <th>No</th>
                    <th>Judul Buku</th>
                    <th>Tanggal Pinjam</th>
                    <th>Harus Kembali</th>
                    <th>Status</th>
                    <th>Denda</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
            <?php
            $no = 1;
            $result = mysqli_query($koneksi,
                "SELECT transaksi.id_transaksi,
                        buku.judul,
                        transaksi.tanggal_pinjam,
                        transaksi.tanggal_harus_kembali,
                        transaksi.status,
                        transaksi.denda
                 FROM transaksi
                 JOIN buku ON transaksi.id_buku = buku.id_buku
                 WHERE transaksi.id_anggota='$id_anggota'
                 AND transaksi.status='Dipinjam'
                 ORDER BY transaksi.id_transaksi DESC"
            );

            if (mysqli_num_rows($result) == 0) {
                echo "<tr>
                        <td colspan='7' class='text-center text-muted'>
                            Tidak ada buku yang sedang dipinjam 📚
                        </td>
                      </tr>";
            }

            while ($row = mysqli_fetch_assoc($result)) {
            ?>
                <tr>
                    <td class="text-center"><?= $no++; ?></td>

                    <td><?= $row['judul']; ?></td>

                    <td class="text-center"><?= $row['tanggal_pinjam']; ?></td>

                    <td class="text-center"><?= $row['tanggal_harus_kembali']; ?></td>

                    <!-- STATUS -->
                    <td class="text-center">
                        <span class="badge bg-warning text-dark">
                            <i class="bi bi-bookmark-check me-1"></i>
                            Dipinjam
                        </span>
                    </td>

                    <!-- DENDA -->
                    <td class="text-center">
                        <?php if ($row['denda'] > 0) { ?>
                            <span class="badge bg-danger">
                                Rp <?= number_format($row['denda'], 0, ',', '.'); ?>
                            </span>
                        <?php } else { ?>
                            <span class="badge bg-success">
                                Rp 0
                            </span>
                        <?php } ?>
                    </td>

                    <!-- AKSI -->
                    <td class="text-center">
                        <a href="?kembali=<?= $row['id_transaksi']; ?>"
                           class="btn btn-sm btn-danger"
                           onclick="return confirm('Kembalikan buku ini?')">
                           <i class="bi bi-arrow-repeat"></i> Kembalikan
                        </a>
                    </td>
                </tr>

            <?php } ?>
            </tbody>
        </table>

        <p class="text-muted mt-3 mb-0">
            📌 Jika terlambat, denda otomatis <strong>Rp 1.000/hari</strong>.
        </p>

    </div>
</div>

<?php include '../layout/footer.php'; ?>

<?php
session_start();
if (!isset($_SESSION['siswa'])) {
    header("Location: ../auth/login.php");
    exit;
}
include '../config/koneksi.php';

$id_anggota = $_SESSION['id_anggota'];

/* ===============================
   CEK APAKAH SISWA MASIH PINJAM
   =============================== */
$cekAktif = mysqli_query($koneksi,
    "SELECT * FROM transaksi 
     WHERE id_anggota='$id_anggota' 
     AND status='Dipinjam'"
);
$masihPinjam = mysqli_num_rows($cekAktif) > 0;

/* ===============================
   PROSES PINJAM
   =============================== */
if (isset($_GET['pinjam'])) {
    $id_buku = $_GET['pinjam'];

    // jika masih pinjam buku lain
    if ($masihPinjam) {
        echo "<script>
            alert('Kamu masih punya buku yang belum dikembalikan!');
            window.location='pinjam.php';
        </script>";
        exit;
    }

    // cek stok buku
    $cek = mysqli_query($koneksi,
        "SELECT stok FROM buku WHERE id_buku='$id_buku'"
    );
    $buku = mysqli_fetch_assoc($cek);

    if ($buku && $buku['stok'] > 0) {

        // insert transaksi + otomatis harus kembali 7 hari
        mysqli_query($koneksi,
            "INSERT INTO transaksi 
            (id_anggota, id_buku, tanggal_pinjam, tanggal_harus_kembali, status)
             VALUES 
            ('$id_anggota','$id_buku', CURDATE(), DATE_ADD(CURDATE(), INTERVAL 7 DAY), 'Dipinjam')"
        );

        // kurangi stok buku
        mysqli_query($koneksi,
            "UPDATE buku SET stok = stok - 1 WHERE id_buku='$id_buku'"
        );

        header("Location: pinjam.php");
        exit;
    }
}
?>

<?php include '../layout/header_siswa.php'; ?>

<h4 class="fw-bold mb-3">Peminjaman Buku</h4>
<a href="dashboard.php" class="btn btn-secondary btn-sm mb-3">← Kembali</a>

<?php if ($masihPinjam) { ?>
    <div class="alert alert-warning">
        Kamu masih memiliki <strong>buku yang sedang dipinjam</strong>.
        Silakan kembalikan terlebih dahulu.
    </div>
<?php } ?>

<div class="card shadow-sm">
    <div class="card-body">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-success text-center">
                <tr>
                    <th>No</th>
                    <th>Judul</th>
                    <th>Pengarang</th>
                    <th>Penerbit</th>
                    <th>Tahun</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $no = 1;
            $result = mysqli_query($koneksi, "SELECT * FROM buku");
            while ($row = mysqli_fetch_assoc($result)) {
            ?>
                <tr>
                    <td class="text-center"><?= $no++; ?></td>
                    <td><?= $row['judul']; ?></td>
                    <td><?= $row['pengarang']; ?></td>
                    <td><?= $row['penerbit']; ?></td>
                    <td class="text-center"><?= $row['tahun_terbit']; ?></td>
                    <td class="text-center"><?= $row['stok']; ?></td>
                    <td class="text-center">
                        <?php if ($row['stok'] > 0 && !$masihPinjam) { ?>
                            <a href="?pinjam=<?= $row['id_buku']; ?>"
                               class="btn btn-sm btn-success"
                               onclick="return confirm('Pinjam buku ini?')">
                               Pinjam
                            </a>
                        <?php } elseif ($masihPinjam) { ?>
                            <span class="badge bg-secondary">Masih Pinjam</span>
                        <?php } else { ?>
                            <span class="badge bg-danger">Habis</span>
                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>

        <p class="text-muted mt-3 mb-0">
            📌 Durasi peminjaman maksimal <strong>7 hari</strong>.
        </p>
    </div>
</div>

<?php include '../layout/footer.php'; ?>

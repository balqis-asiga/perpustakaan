<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../auth/login.php");
    exit;
}

include '../config/koneksi.php';

/* =========================
   PROSES KEMBALIKAN (ADMIN)
========================= */
if (isset($_GET['kembali'])) {

    $id_transaksi = $_GET['kembali'];

    // ambil transaksi
    $data = mysqli_fetch_assoc(mysqli_query($koneksi,
        "SELECT id_buku, tanggal_harus_kembali 
         FROM transaksi 
         WHERE id_transaksi='$id_transaksi'"
    ));

    if ($data) {

        $id_buku = $data['id_buku'];
        $tgl_harus = $data['tanggal_harus_kembali'];
        $tgl_sekarang = date("Y-m-d");

        // hitung keterlambatan
        $selisih = (strtotime($tgl_sekarang) - strtotime($tgl_harus)) / 86400;

        $denda = 0;
        $status = "Dikembalikan";

        if ($selisih > 0) {
            $denda = $selisih * 1000;
            $status = "Terlambat";
        }

        // update transaksi
        mysqli_query($koneksi,
            "UPDATE transaksi SET 
                status='$status',
                tanggal_kembali=CURDATE(),
                denda='$denda'
             WHERE id_transaksi='$id_transaksi'"
        );

        // tambah stok buku
        mysqli_query($koneksi,
            "UPDATE buku SET stok = stok + 1 
             WHERE id_buku='$id_buku'"
        );
    }

    header("Location: transaksi.php");
    exit;
}

/* =========================
   PROSES HAPUS TRANSAKSI
========================= */
if (isset($_GET['hapus'])) {

    $id_transaksi = $_GET['hapus'];

    mysqli_query($koneksi,
        "DELETE FROM transaksi WHERE id_transaksi='$id_transaksi'"
    );

    header("Location: transaksi.php");
    exit;
}

/* =========================
   FILTER STATUS TRANSAKSI
========================= */
$statusFilter = "";

if (isset($_GET['filter'])) {
    $filter = $_GET['filter'];

    if ($filter != "all") {
        $statusFilter = "WHERE transaksi.status='$filter'";
    }
}

include '../layout/header_admin.php';
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="fw-bold">Data Transaksi Peminjaman Buku</h4>
</div>

<!-- =========================
     TOTAL DENDA
========================= -->
<?php
$totalDenda = mysqli_fetch_assoc(mysqli_query($koneksi,
    "SELECT SUM(denda) AS total FROM transaksi"
));
?>

<div class="alert alert-danger shadow-sm">
    <strong>Total Denda Semua Transaksi:</strong>
    Rp<?= number_format($totalDenda['total'] ?? 0); ?>
</div>

<!-- =========================
     FILTER DROPDOWN
========================= -->
<form method="GET" class="mb-3">
    <div class="row g-2">
        <div class="col-md-4">
            <select name="filter" class="form-select" onchange="this.form.submit()">
                <option value="all" <?= (!isset($_GET['filter']) || $_GET['filter']=="all") ? "selected" : ""; ?>>
                    Semua Status
                </option>
                <option value="Dipinjam" <?= ($_GET['filter'] ?? "")=="Dipinjam" ? "selected" : ""; ?>>
                    Dipinjam
                </option>
                <option value="Terlambat" <?= ($_GET['filter'] ?? "")=="Terlambat" ? "selected" : ""; ?>>
                    Terlambat
                </option>
                <option value="Dikembalikan" <?= ($_GET['filter'] ?? "")=="Dikembalikan" ? "selected" : ""; ?>>
                    Dikembalikan
                </option>
            </select>
        </div>
    </div>
</form>

<div class="card shadow-sm">
  <div class="card-body table-responsive">

    <table class="table table-hover align-middle">
      <thead class="table-dark">
        <tr>
            <th>No</th>
            <th>Nama Siswa</th>
            <th>Judul Buku</th>
            <th>Tgl Pinjam</th>
            <th>Harus Kembali</th>
            <th>Tgl Kembali</th>
            <th>Status</th>
            <th>Denda</th>
            <th class="text-center">Aksi</th>
        </tr>
      </thead>

      <tbody>
      <?php
      $no = 1;

      $query = mysqli_query($koneksi,
          "SELECT transaksi.*,
                  anggota.nama,
                  buku.judul
           FROM transaksi
           JOIN anggota ON transaksi.id_anggota = anggota.id_anggota
           JOIN buku ON transaksi.id_buku = buku.id_buku
           $statusFilter
           ORDER BY transaksi.id_transaksi DESC"
      );

      if (mysqli_num_rows($query) == 0) {
          echo "<tr>
                  <td colspan='9' class='text-center text-muted'>
                      Tidak ada transaksi dengan status ini
                  </td>
                </tr>";
      }

      while ($row = mysqli_fetch_assoc($query)) {
      ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= $row['nama']; ?></td>
            <td><?= $row['judul']; ?></td>
            <td><?= $row['tanggal_pinjam']; ?></td>

            <td>
                <span class="badge bg-info text-dark">
                    <?= $row['tanggal_harus_kembali']; ?>
                </span>
            </td>

            <td><?= $row['tanggal_kembali'] ?: '-'; ?></td>

            <!-- STATUS -->
            <td>
                <?php if ($row['status'] == 'Dipinjam') { ?>
                    <span class="badge bg-warning text-dark">Dipinjam</span>

                <?php } elseif ($row['status'] == 'Terlambat') { ?>
                    <span class="badge bg-danger">Terlambat</span>

                <?php } else { ?>
                    <span class="badge bg-success">Dikembalikan</span>
                <?php } ?>
            </td>

            <!-- DENDA -->
            <td>
                <?php if ($row['denda'] > 0) { ?>
                    <span class="badge bg-danger">
                        Rp<?= number_format($row['denda']); ?>
                    </span>
                <?php } else { ?>
                    <span class="badge bg-success">Rp0</span>
                <?php } ?>
            </td>

            <!-- AKSI -->
            <td class="text-center">

                <?php if ($row['status'] == 'Dipinjam') { ?>
                    <a href="?kembali=<?= $row['id_transaksi']; ?>"
                       class="btn btn-sm btn-success"
                       onclick="return confirm('Kembalikan buku ini?')">
                        Kembalikan
                    </a>
                <?php } ?>

                <a href="?hapus=<?= $row['id_transaksi']; ?>"
                   class="btn btn-sm btn-danger"
                   onclick="return confirm('Hapus transaksi ini?')">
                    Hapus
                </a>

            </td>
        </tr>
      <?php } ?>
      </tbody>
    </table>

  </div>
</div>

<?php include '../layout/footer.php'; ?>

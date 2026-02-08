<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../auth/login.php");
    exit;
}

include '../config/koneksi.php';
include '../layout/header_admin.php';


/* =========================
   SEARCH BUKU
========================= */
$search = "";
if (isset($_GET['search'])) {
    $search = mysqli_real_escape_string($koneksi, $_GET['search']);
}


/* =========================
   TAMBAH BUKU
========================= */
if (isset($_POST['tambah'])) {

    $judul       = $_POST['judul'];
    $pengarang   = $_POST['pengarang'];
    $penerbit    = $_POST['penerbit'];
    $tahun       = $_POST['tahun'];
    $stok        = $_POST['stok'];

    $isbn        = $_POST['isbn'];
    $rak         = $_POST['rak'];
    $deskripsi   = $_POST['deskripsi'];

    // kategori boleh kosong → NULL
    $id_kategori = ($_POST['id_kategori'] == "") ? NULL : $_POST['id_kategori'];

    mysqli_query($koneksi,
        "INSERT INTO buku 
        (judul, pengarang, penerbit, tahun_terbit, stok, isbn, rak, id_kategori, deskripsi)
        VALUES
        ('$judul','$pengarang','$penerbit','$tahun','$stok',
         '$isbn','$rak',".($id_kategori ? "'$id_kategori'" : "NULL").",'$deskripsi')"
    );

    header("Location: buku.php");
    exit;
}


/* =========================
   HAPUS BUKU
========================= */
if (isset($_GET['hapus'])) {
    mysqli_query($koneksi, "DELETE FROM buku WHERE id_buku='$_GET[hapus]'");
    header("Location: buku.php");
    exit;
}


/* =========================
   AMBIL DATA EDIT
========================= */
$edit = false;
if (isset($_GET['edit'])) {
    $edit = true;
    $id = $_GET['edit'];

    $data_edit = mysqli_fetch_assoc(
        mysqli_query($koneksi, "SELECT * FROM buku WHERE id_buku='$id'")
    );
}


/* =========================
   UPDATE BUKU
========================= */
if (isset($_POST['update'])) {

    $id_kategori = ($_POST['id_kategori'] == "") ? NULL : $_POST['id_kategori'];

    mysqli_query($koneksi,
        "UPDATE buku SET
            judul='$_POST[judul]',
            pengarang='$_POST[pengarang]',
            penerbit='$_POST[penerbit]',
            tahun_terbit='$_POST[tahun]',
            stok='$_POST[stok]',
            isbn='$_POST[isbn]',
            rak='$_POST[rak]',
            id_kategori=".($id_kategori ? "'$id_kategori'" : "NULL").",
            deskripsi='$_POST[deskripsi]'
         WHERE id_buku='$_POST[id_buku]'"
    );

    header("Location: buku.php");
    exit;
}
?>


<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="fw-bold">Kelola Data Buku</h4>
</div>


<!-- =========================
     SEARCH FORM
========================= -->
<form method="GET" class="mb-3">
    <div class="input-group">
        <input type="text" name="search" class="form-control"
               placeholder="Cari judul / pengarang / ISBN..."
               value="<?= $search; ?>">
        <button class="btn btn-dark" type="submit">
            Cari
        </button>
        <a href="buku.php" class="btn btn-secondary">
            Reset
        </a>
    </div>
</form>


<!-- =========================
     FORM TAMBAH / EDIT
========================= -->
<div class="card mb-4 shadow-sm">
  <div class="card-body">

    <form method="POST">

        <?php if ($edit) { ?>
            <input type="hidden" name="id_buku" value="<?= $data_edit['id_buku']; ?>">
        <?php } ?>

        <div class="row">

            <div class="col-md-6 mb-3">
                <label class="form-label">Judul Buku</label>
                <input type="text" name="judul" class="form-control" required
                    value="<?= $edit ? $data_edit['judul'] : ''; ?>">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Pengarang</label>
                <input type="text" name="pengarang" class="form-control" required
                    value="<?= $edit ? $data_edit['pengarang'] : ''; ?>">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Penerbit</label>
                <input type="text" name="penerbit" class="form-control" required
                    value="<?= $edit ? $data_edit['penerbit'] : ''; ?>">
            </div>

            <div class="col-md-3 mb-3">
                <label class="form-label">Tahun Terbit</label>
                <input type="number" name="tahun" class="form-control" required
                    value="<?= $edit ? $data_edit['tahun_terbit'] : ''; ?>">
            </div>

            <div class="col-md-3 mb-3">
                <label class="form-label">Stok</label>
                <input type="number" name="stok" class="form-control" required
                    value="<?= $edit ? $data_edit['stok'] : ''; ?>">
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">ISBN</label>
                <input type="text" name="isbn" class="form-control"
                    value="<?= $edit ? $data_edit['isbn'] : ''; ?>">
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">Rak</label>
                <input type="text" name="rak" class="form-control"
                    value="<?= $edit ? $data_edit['rak'] : ''; ?>">
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">Kategori</label>
                <select name="id_kategori" class="form-select">
                    <option value="">-- Pilih --</option>

                    <?php
                    $kategori = mysqli_query($koneksi, "SELECT * FROM kategori");
                    while ($k = mysqli_fetch_assoc($kategori)) {
                        $selected = ($edit && $data_edit['id_kategori'] == $k['id_kategori'])
                            ? "selected" : "";
                    ?>
                        <option value="<?= $k['id_kategori']; ?>" <?= $selected; ?>>
                            <?= $k['nama_kategori']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="col-md-12 mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea name="deskripsi" class="form-control" rows="3"><?= $edit ? $data_edit['deskripsi'] : ''; ?></textarea>
            </div>

        </div>

        <?php if ($edit) { ?>
            <button type="submit" name="update" class="btn btn-warning">
                Update Buku
            </button>
            <a href="buku.php" class="btn btn-secondary">
                Batal
            </a>
        <?php } else { ?>
            <button type="submit" name="tambah" class="btn btn-primary">
                Tambah Buku
            </button>
        <?php } ?>

    </form>

  </div>
</div>


<!-- =========================
     TABEL DATA BUKU
========================= -->
<div class="card shadow-sm">
  <div class="card-body table-responsive">

    <table class="table table-bordered table-hover align-middle">
      <thead class="table-dark text-center">
        <tr>
            <th>No</th>
            <th>Judul</th>
            <th>ISBN</th>
            <th>Rak</th>
            <th>Stok</th>
            <th width="180">Aksi</th>
        </tr>
      </thead>

      <tbody>
      <?php
      $no = 1;

      $query = "SELECT buku.*, kategori.nama_kategori
                FROM buku
                LEFT JOIN kategori ON buku.id_kategori = kategori.id_kategori";

      if ($search != "") {
          $query .= " WHERE judul LIKE '%$search%'
                      OR pengarang LIKE '%$search%'
                      OR isbn LIKE '%$search%'";
      }

      $query .= " ORDER BY id_buku DESC";

      $data = mysqli_query($koneksi, $query);

      while ($row = mysqli_fetch_assoc($data)) {
      ?>
        <tr>
            <td class="text-center"><?= $no++; ?></td>

            <td>
                <strong><?= $row['judul']; ?></strong><br>
                <small class="text-muted">
                    <?= $row['nama_kategori'] ?? '-'; ?>
                </small>
            </td>

            <td class="text-center"><?= $row['isbn'] ?: '-'; ?></td>
            <td class="text-center"><?= $row['rak'] ?: '-'; ?></td>
            <td class="text-center"><?= $row['stok']; ?></td>

            <td class="text-center">
                <a href="?edit=<?= $row['id_buku']; ?>" class="btn btn-warning btn-sm">
                    Edit
                </a>

                <a href="?hapus=<?= $row['id_buku']; ?>"
                   class="btn btn-danger btn-sm"
                   onclick="return confirm('Hapus buku ini?')">
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

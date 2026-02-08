<?php
session_start();
include '../config/koneksi.php';
include '../layout/header_admin.php';


/* =========================
   SEARCH ANGGOTA
========================= */
$search = "";
if (isset($_GET['search'])) {
    $search = mysqli_real_escape_string($koneksi, $_GET['search']);
}


/* =========================
   TAMBAH ANGGOTA
========================= */
if (isset($_POST['tambah'])) {
    mysqli_query($koneksi,
        "INSERT INTO anggota (nis, nama, kelas, username, password)
         VALUES (
            '$_POST[nis]',
            '$_POST[nama]',
            '$_POST[kelas]',
            '$_POST[username]',
            '$_POST[password]'
         )"
    );
    header("Location: anggota.php");
    exit;
}


/* =========================
   HAPUS ANGGOTA
========================= */
if (isset($_GET['hapus'])) {
    mysqli_query($koneksi, "DELETE FROM anggota WHERE id_anggota='$_GET[hapus]'");
    header("Location: anggota.php");
    exit;
}


/* =========================
   AMBIL DATA EDIT
========================= */
$edit = false;
if (isset($_GET['edit'])) {
    $edit = true;
    $data_edit = mysqli_fetch_assoc(
        mysqli_query($koneksi, "SELECT * FROM anggota WHERE id_anggota='$_GET[edit]'")
    );
}


/* =========================
   UPDATE ANGGOTA
========================= */
if (isset($_POST['update'])) {
    mysqli_query($koneksi,
        "UPDATE anggota SET
            nis='$_POST[nis]',
            nama='$_POST[nama]',
            kelas='$_POST[kelas]',
            username='$_POST[username]',
            password='$_POST[password]'
         WHERE id_anggota='$_POST[id_anggota]'"
    );
    header("Location: anggota.php");
    exit;
}
?>


<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="fw-bold">Kelola Data Anggota</h4>
</div>


<!-- =========================
     SEARCH FORM
========================= -->
<form method="GET" class="mb-3">
    <div class="input-group">
        <input type="text" name="search" class="form-control"
               placeholder="Cari NIS / Nama / Kelas..."
               value="<?= $search; ?>">
        <button class="btn btn-dark" type="submit">Cari</button>
        <a href="anggota.php" class="btn btn-secondary">Reset</a>
    </div>
</form>


<!-- FORM -->
<div class="card mb-4">
  <div class="card-body">
    <form method="POST">
        <?php if ($edit) { ?>
            <input type="hidden" name="id_anggota" value="<?= $data_edit['id_anggota']; ?>">
        <?php } ?>

        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label">NIS</label>
                <input type="text" name="nis" class="form-control" required
                       value="<?= $edit ? $data_edit['nis'] : ''; ?>">
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">Nama</label>
                <input type="text" name="nama" class="form-control" required
                       value="<?= $edit ? $data_edit['nama'] : ''; ?>">
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">Kelas</label>
                <input type="text" name="kelas" class="form-control" required
                       value="<?= $edit ? $data_edit['kelas'] : ''; ?>">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" required
                       value="<?= $edit ? $data_edit['username'] : ''; ?>">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Password</label>
                <input type="text" name="password" class="form-control" required
                       value="<?= $edit ? $data_edit['password'] : ''; ?>">
            </div>
        </div>

        <?php if ($edit) { ?>
            <button type="submit" name="update" class="btn btn-warning">Update</button>
            <a href="anggota.php" class="btn btn-secondary">Batal</a>
        <?php } else { ?>
            <button type="submit" name="tambah" class="btn btn-primary">Tambah</button>
        <?php } ?>
    </form>
  </div>
</div>


<!-- TABEL -->
<table class="table table-bordered table-striped table-hover">
<thead class="table-dark">
<tr>
    <th>No</th>
    <th>NIS</th>
    <th>Nama</th>
    <th>Kelas</th>
    <th>Username</th>
    <th width="150">Aksi</th>
</tr>
</thead>
<tbody>
<?php
$no = 1;

$query = "SELECT * FROM anggota";

if ($search != "") {
    $query .= " WHERE nis LIKE '%$search%'
                OR nama LIKE '%$search%'
                OR kelas LIKE '%$search%'";
}

$query .= " ORDER BY id_anggota DESC";

$data = mysqli_query($koneksi, $query);

while ($row = mysqli_fetch_assoc($data)) {
?>
<tr>
    <td><?= $no++; ?></td>
    <td><?= $row['nis']; ?></td>
    <td><?= $row['nama']; ?></td>
    <td><?= $row['kelas']; ?></td>
    <td><?= $row['username']; ?></td>
    <td>
        <a href="?edit=<?= $row['id_anggota']; ?>" class="btn btn-warning btn-sm">Edit</a>
        <a href="?hapus=<?= $row['id_anggota']; ?>"
           class="btn btn-danger btn-sm"
           onclick="return confirm('Hapus anggota ini?')">
           Hapus
        </a>
    </td>
</tr>
<?php } ?>
</tbody>
</table>

<?php include '../layout/footer.php'; ?>

<?php
// Konfigurasi database
$host = "localhost";
$user = "root";
$pass = "";
$db   = "perpustakaan";

// Membuat koneksi
$koneksi = mysqli_connect($host, $user, $pass, $db);

// Cek koneksi
if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>

# Aplikasi Perpustakaan Digital UKK

## Cara Menjalankan Project

1. Clone repository ini
2. Pindahkan folder ke:

   C:\xampp\htdocs\

3. Jalankan Apache & MySQL di XAMPP
4. Import database `perpustakaan.sql` ke phpMyAdmin
5. Buka browser:

   http://localhost/perpustakaan/

## Login Admin
username: admin  
password: admin123

--------------------------------
https://github.com/balqis-asiga/perpustakaan.git
______________________________________

__________________
✅ Cara Teman Kamu Clone Project

Kalau repo kamu udah public:
Teman kamu tinggal:

Buka VS Code

Klik:
Clone Repository

Paste link repo GitHub kamu, contoh:
https://github.com/balqis-asiga/perpustakaan.git


Pilih folder penyimpanan

Setelah selesai clone, jalankan di XAMPP:

Taruh folder ke:
htdocs/

Lalu buka:
localhost/perpustakaan
__________________
✅ STEP 3 — Teman Kamu Clone Projectnya

Sekarang bagian temenmu.

Cara Clone Repository di komputer teman
1. Install dulu wajib:

Temanmu harus punya:

✅ Git
Download: https://git-scm.com/

✅ XAMPP

✅ VS Code

Cara Clone:
1. Buka VS Code
2. Klik:
Ctrl + Shift + P


Cari:

Git: Clone


Klik.

3. Masukkan link repo GitHub kamu

Di GitHub repo kamu klik tombol hijau:

✅ Code → Copy HTTPS

Misal:

https://github.com/balqis/perpustakaan-ukk.git


Paste di VS Code.

4. Pilih folder tempat clone

Misalnya:

D:\projek-clone\


VS Code akan bikin folder otomatis.

5. Setelah selesai

VS Code akan nanya:

✅ Open repository?

Klik YES.

✅ STEP 4 — Cara Teman Menjalankan Project PHP Native

Nah ini penting banget:

Project PHP gak bisa langsung run kayak Java.

Harus lewat XAMPP.

Langkah Temanmu:
1. Pindahkan folder hasil clone ke:
C:\xampp\htdocs\


Jadi:

C:\xampp\htdocs\perpustakaan-ukk\

2. Jalankan XAMPP

Start:

✅ Apache
✅ MySQL

3. Import Database

Karena database gak ikut otomatis.

Kamu harus kasih file:

perpustakaan.sql


Cara import:

buka phpMyAdmin

buat database:

perpustakaan


klik Import

pilih file .sql

klik Go

4. Sesuaikan koneksi database

Di file:

config/koneksi.php

Pastikan:

$koneksi = mysqli_connect("localhost","root","","perpustakaan");


Kalau sama → aman.

5. Jalankan di browser

Teman buka:

http://localhost/perpustakaan-ukk/


🎉 Project berhasil jalan.
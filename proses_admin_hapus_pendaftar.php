<?php
session_start();

// 1. Konfigurasi Koneksi Database

// Menghubungkan otomatis jika menggunakan Coolify MariaDB / Database URL

// Hardcoded Connect to Internal MariaDB Database Hosted on Coolify 
$host = "tksg48cgw04gk08sowc84sss";
$user = "mysql";
$pass = "poAAEXvLO3QsOiYz66me2qBciagEvbpg1To3kf2VXYUagDEht6sXzcSbV21uJnZI";
$db   = "default";
$port = 3306;

}

}

}

}
 

$koneksi = mysqli_connect($host, $user, $pass, $db, $port);

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// 2. Cek apakah Admin sudah login (Keamanan)
// Sesuaikan $_SESSION['role'] dengan sistem login Anda jika ada
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// 3. Proses Hapus Data
if (isset($_GET['id'])) {
    // Ambil ID dari URL
    $id_daftar = $_GET['id'];

    // Mencegah SQL Injection sederhana
    $id_daftar = mysqli_real_escape_string($koneksi, $id_daftar);

    // Query Hapus
    $query = "DELETE FROM t_pendaftaran WHERE id_daftar = '$id_daftar'";
    $hasil = mysqli_query($koneksi, $query);

    // 4. Redirect (Pengalihan)
    if ($hasil) {
        // Jika berhasil, kembali ke halaman admin dengan status sukses
        header("Location: admin_lihat_pendaftar.php?status=hapus_sukses");
    } else {
        // Jika gagal query
        header("Location: admin_lihat_pendaftar.php?status=gagal");
    }
} else {
    // Jika file ini dibuka tanpa ID, kembalikan saja
    header("Location: admin_lihat_pendaftar.php");
}

exit();
?>
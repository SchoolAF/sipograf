<?php
// Konfigurasi database

// Hardcoded Connect to Internal MariaDB Database Hosted on Coolify 
$host = "tksg48cgw04gk08sowc84sss";
$user = "mysql";
$pass = "poAAEXvLO3QsOiYz66me2qBciagEvbpg1To3kf2VXYUagDEht6sXzcSbV21uJnZI";
$db   = "default";
$port = 3306;

// Membuat koneksi menggunakan MySQLi (agar cocok dengan home.php)
$koneksi = mysqli_connect($host, $user, $pass, $db, $port);

// Cek koneksi
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
<?php
// Konfigurasi Database (Mendukung Environment Variables dari Docker/Coolify)
$host = getenv('DB_HOST') ?: "127.0.0.1";
$user = getenv('DB_USER') ?: "root";
$pass = getenv('DB_PASS') !== false ? getenv('DB_PASS') : "";
$db = getenv('DB_NAME') ?: "dbsipograf1";
$port = getenv('DB_PORT') ?: 3307; // Port default

// Membuat koneksi menggunakan MySQLi (agar cocok dengan home.php)
$koneksi = mysqli_connect($host, $user, $pass, $db, $port);

// Cek koneksi
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
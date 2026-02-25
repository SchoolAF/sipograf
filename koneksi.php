<?php
// Konfigurasi Database (Mendukung Environment Variables dari Docker/Coolify)

// Menghubungkan otomatis jika menggunakan Coolify MariaDB / Database URL
$db_url = getenv('DATABASE_URL');
if ($db_url) {
    $url = parse_url($db_url);
    $host = $url['host'] ?? "127.0.0.1";
    $user = $url['user'] ?? "root";
    $pass = $url['pass'] ?? "";
    $db   = isset($url['path']) ? ltrim($url['path'], '/') : "dbsipograf1";
    $port = $url['port'] ?? 3306;
} else {
    
// Menghubungkan otomatis jika menggunakan Coolify MariaDB / Database URL
$db_url = getenv('DATABASE_URL') ?: "mysql://mysql:poAAEXvLO3QsOiYz66me2qBciagEvbpg1To3kf2VXYUagDEht6sXzcSbV21uJnZI@87.239.129.130:55431/default";
if ($db_url) {
    $url = parse_url($db_url);
    $host = $url['host'] ?? "127.0.0.1";
    $user = $url['user'] ?? "root";
    $pass = $url['pass'] ?? "";
    $db   = isset($url['path']) ? ltrim($url['path'], '/') : "dbsipograf1";
    $port = $url['port'] ?? 3306;
} else {
    
// Menghubungkan otomatis jika menggunakan Coolify MariaDB / Database URL
$db_url = getenv('DATABASE_URL') ?: "mysql://mysql:poAAEXvLO3QsOiYz66me2qBciagEvbpg1To3kf2VXYUagDEht6sXzcSbV21uJnZI@tksg48cgw04gk08sowc84sss:3306/default";
if ($db_url) {
    $url = parse_url($db_url);
    $host = $url['host'] ?? "127.0.0.1";
    $user = $url['user'] ?? "root";
    $pass = $url['pass'] ?? "";
    $db   = isset($url['path']) ? ltrim($url['path'], '/') : "dbsipograf1";
    $port = $url['port'] ?? 3306;
} else {
    $host = getenv('DB_HOST') ?: "localhost";
    $user = getenv('DB_USER') ?: "root";
    $pass = getenv('DB_PASS') !== false ? getenv('DB_PASS') : "";
    $db   = getenv('DB_NAME') ?: "dbsipograf1";
    $port = getenv('DB_PORT') ?: 3306;
}

}

}
 // Port default

// Membuat koneksi menggunakan MySQLi (agar cocok dengan home.php)
$koneksi = mysqli_connect($host, $user, $pass, $db, $port);

// Cek koneksi
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
<?php
$files = [
    'penimbangan/kms.php',
    'proses_admin_jadwal.php',
    'proses_admin_hapus_pendaftar.php',
    'coverage/koneksi.php',
    'admin_jadwal.php',
    'proses_daftar.php',
    'admin_lihat_pendaftar.php',
    'koneksi.php',
    'login.php'
];

$replacement = <<<REPLACE
// Parsing DATABASE_URL provided by Coolify automatically
\$db_url = getenv('DATABASE_URL');
if (\$db_url) {
    \$url = parse_url(\$db_url);
    \$host = \$url['host'] ?? "127.0.0.1";
    \$user = \$url['user'] ?? "root";
    \$pass = \$url['pass'] ?? "";
    \$db   = isset(\$url['path']) ? ltrim(\$url['path'], '/') : "dbsipograf1";
    \$port = \$url['port'] ?? 3306;
} else {
    \$host = getenv('DB_HOST') ?: "localhost";
    \$user = getenv('DB_USER') ?: "root";
    \$pass = getenv('DB_PASS') !== false ? getenv('DB_PASS') : "";
    \$db   = getenv('DB_NAME') ?: "dbsipograf1";
    \$port = getenv('DB_PORT') ?: 3306;
}
REPLACE;

foreach ($files as $file) {
    if (file_exists($file)) {
        $content = file_get_contents($file);
        
        // Remove old getenv logic and replace with advanced URL parser
        $content = preg_replace('/\$host\s*=\s*getenv\([^;]+;\s*\$user\s*=\s*getenv\([^;]+;\s*\$pass\s*=\s*getenv\([^;]+;\s*\$db\s*=\s*getenv\([^;]+;\s*\$port\s*=\s*getenv\([^;]+;/is', $replacement, $content);
        
        // Also handle the servername in login.php specifically
        $content = preg_replace('/\$servername\s*=\s*getenv\([^;]+;\s*\$username\s*=\s*getenv\([^;]+;\s*\$password\s*=\s*getenv\([^;]+;\s*\$dbname\s*=\s*getenv\([^;]+;/is', str_replace(['$host', '$user', '$pass', '$db', '$port'], ['$servername', '$username', '$password', '$dbname', '$dbport'], $replacement), $content);
        
        file_put_contents($file, $content);
        echo "Updated \$file\n";
    }
}

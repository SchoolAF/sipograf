import os
import re

files = [
    'penimbangan/kms.php',
    'proses_admin_jadwal.php',
    'proses_admin_hapus_pendaftar.php',
    'coverage/koneksi.php',
    'admin_jadwal.php',
    'proses_daftar.php',
    'admin_lihat_pendaftar.php',
    'koneksi.php',
    'login.php'
]

replacement = """
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
"""

replacement_login = """
// Menghubungkan otomatis jika menggunakan Coolify MariaDB / Database URL
$db_url = getenv('DATABASE_URL') ?: "mysql://mysql:poAAEXvLO3QsOiYz66me2qBciagEvbpg1To3kf2VXYUagDEht6sXzcSbV21uJnZI@tksg48cgw04gk08sowc84sss:3306/default";
if ($db_url) {
    $url = parse_url($db_url);
    $servername = $url['host'] ?? "127.0.0.1";
    $username = $url['user'] ?? "root";
    $password = $url['pass'] ?? "";
    $dbname   = isset($url['path']) ? ltrim($url['path'], '/') : "dbsipograf1";
    $port = $url['port'] ?? 3306;
} else {
    $servername = getenv('DB_HOST') ?: "localhost";
    $username = getenv('DB_USER') ?: "root";
    $password = getenv('DB_PASS') !== false ? getenv('DB_PASS') : "";
    $dbname   = getenv('DB_NAME') ?: "dbsipograf1";
    $port = getenv('DB_PORT') ?: 3306;
}
"""

for file in files:
    path = os.path.join('/home/buxx/Desktop/web/p2', file)
    if not os.path.exists(path): continue
    
    with open(path, 'r') as f:
        content = f.read()
    
    # Generic files
    pattern1 = re.compile(
        r'\$host\s*=\s*getenv\([^;]*;\s*'
        r'\$user\s*=\s*getenv\([^;]*;\s*'
        r'\$pass\s*=\s*getenv\([^;]*;\s*'
        r'\$db\s*=\s*getenv\([^;]*;\s*'
        r'\$port\s*=\s*getenv\([^;]*[^;]*;',
        re.IGNORECASE | re.MULTILINE | re.DOTALL
    )
    
    # Login.php specific variables
    pattern2 = re.compile(
        r'\$servername\s*=\s*getenv\([^;]*;\s*'
        r'\$username\s*=\s*getenv\([^;]*;\s*'
        r'\$password\s*=\s*getenv\([^;]*;\s*'
        r'\$dbname\s*=\s*getenv\([^;]*;\s*',
        re.IGNORECASE | re.MULTILINE | re.DOTALL
    )
    
    if file == 'login.php':
        new_content, count = pattern2.subn(replacement_login, content)
        # Handle instantiation to include port because login didn't have port originally
        new_content = re.sub(r'new mysqli\(\$servername, \$username, \$password, \$dbname\);', 'new mysqli($servername, $username, $password, $dbname, $port);', new_content)
    else:
        new_content, count = pattern1.subn(replacement, content)
        
    if count > 0:
        with open(path, 'w') as f:
            f.write(new_content)
        print(f"Updated {file}")

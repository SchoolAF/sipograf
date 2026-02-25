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
]

replacement = """
// Hardcoded Connect to Internal MariaDB Database Hosted on Coolify 
$host = "tksg48cgw04gk08sowc84sss";
$user = "mysql";
$pass = "poAAEXvLO3QsOiYz66me2qBciagEvbpg1To3kf2VXYUagDEht6sXzcSbV21uJnZI";
$db   = "default";
$port = 3306;
"""

replacement_login = """
// Hardcoded Connect to Internal MariaDB Database Hosted on Coolify 
$servername = "tksg48cgw04gk08sowc84sss";
$username = "mysql";
$password = "poAAEXvLO3QsOiYz66me2qBciagEvbpg1To3kf2VXYUagDEht6sXzcSbV21uJnZI";
$dbname   = "default";
$port = 3306;
"""

for file in files + ['login.php']:
    path = os.path.join('/home/buxx/Desktop/web/p2', file)
    if not os.path.exists(path): continue
    
    with open(path, 'r') as f:
        content = f.read()

    # Generic files
    pattern1 = re.compile(
        r'\$db_url\s*=\s*getenv\([^;]*;[\s\S]*?\$port = getenv\(\'DB_PORT\'\)[^;]*;',
        re.IGNORECASE | re.MULTILINE
    )
    
    # Login.php specific variables
    pattern2 = re.compile(
        r'\$db_url\s*=\s*getenv\([^;]*;[\s\S]*?\$port = getenv\(\'DB_PORT\'\)[^;]*;',
        re.IGNORECASE | re.MULTILINE
    )
    
    if file == 'login.php':
        new_content, count = pattern2.subn(replacement_login, content)
    else:
        new_content, count = pattern1.subn(replacement, content)
        
    if count > 0:
        with open(path, 'w') as f:
            f.write(new_content)
        print(f"Updated {file}")

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

for file in files:
    path = os.path.join('/home/buxx/Desktop/web/p2', file)
    if not os.path.exists(path): continue
    
    with open(path, 'r') as f:
        content = f.read()

    # Bruteforce strip everything between // Konfigurasi database and // Membuat koneksi ke database 
    # to guarantee clean syntax

    pattern = re.compile(
        r'//\s*Konfigurasi database[\s\S]*?//\s*Membuat koneksi',
        re.IGNORECASE | re.MULTILINE
    )
    
    if file == 'login.php':
        new_content, count = pattern.subn('// Konfigurasi database\n' + replacement_login + '\n// Membuat koneksi', content)
    else:
        new_content, count = pattern.subn('// Konfigurasi database\n' + replacement + '\n// Membuat koneksi', content)
        
    # Edge Case: koneksi.php might not have the exact `// Membuat koneksi ke database` comment, but rather `// Cek koneksi` or similar if the connection is inline
    pattern_alt = re.compile(
        r'//\s*Konfigurasi Database\s*\(Mendukung Environment Variables dari Docker/Coolify\)[\s\S]*?//\s*Membuat koneksi',
        re.IGNORECASE | re.MULTILINE
    )
    
    if count == 0 and file != 'login.php':
         new_content, count = pattern_alt.subn('// Konfigurasi Database\n' + replacement + '\n// Membuat koneksi', content)

    # Some files use require 'koneksi.php' and don't declare credentials natively!
    if count > 0:
        with open(path, 'w') as f:
            f.write(new_content)
        print(f"Cleaned syntax in {file}")


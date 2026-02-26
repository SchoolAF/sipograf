<?php
include_once("koneksi.php");

// 1. Cek apakah ada ID di URL
if (isset($_GET['id_vaksin'])) {
    $id_vaksin = $_GET['id_vaksin'];

    // Avoid SQL injection
    $id_vaksin = mysqli_real_escape_string($koneksi, $id_vaksin);

    // 2. Buat Query Hapus
    $query = "DELETE FROM t_vaksin WHERE id_vaksin = '$id_vaksin'";

    // 3. Eksekusi Query
    $result = mysqli_query($koneksi, $query);

    // 4. Cek Hasil
    if ($result) {
        $message = "Data vaksin berhasil dihapus!";
        $status = "success";
    }
    else {
        $message = "Gagal menghapus data vaksin. Error: " . mysqli_error($koneksi);
        $status = "error";
    }

}
else {
    // Jika ID tidak ada di URL
    $message = "ID Vaksin tidak ditemukan!";
    $status = "error";
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proses Hapus Vaksin</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

    <script>
        Swal.fire({
            title: 'Status Hapus',
            text: '<?php echo $message; ?>',
            icon: '<?php echo $status; ?>',
            confirmButtonText: 'OK'
        }).then((result) => {
            // Setelah klik OK, kembali ke halaman utama atau daftar vaksin
            // Silakan sesuaikan dengan halamannya, karena belum ada data_vaksin.php
            if (result.isConfirmed) {
                window.location.href = 'index.php';
            }
        });
    </script>

</body>

</html>
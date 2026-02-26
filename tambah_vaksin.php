<?php
include 'koneksi.php';

$message = "";
$status = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_vaksin = $_POST['nama_vaksin'];
    $stok = $_POST['stok'];
    $satuan = $_POST['satuan'];
    $keterangan = $_POST['keterangan'];

    // Avoid SQL injection simple mitigation (though parameterized queries are better, this follows the current codebase style like in add.php)
    $nama_vaksin = mysqli_real_escape_string($koneksi, $nama_vaksin);
    $stok = mysqli_real_escape_string($koneksi, $stok);
    $satuan = mysqli_real_escape_string($koneksi, $satuan);
    $keterangan = mysqli_real_escape_string($koneksi, $keterangan);

    $query = "INSERT INTO t_vaksin (nama_vaksin, stok, satuan, keterangan) 
              VALUES ('$nama_vaksin', '$stok', '$satuan', '$keterangan')";

    $result = mysqli_query($koneksi, $query);

    if ($result) {
        $message = "Data vaksin berhasil ditambahkan!";
        $status = "success";
    }
    else {
        $message = "Gagal menambahkan data. Error: " . mysqli_error($koneksi);
        $status = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Vaksin</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div class="container">
        <h2 class="mt-4">Tambah Stok Vaksin</h2>

        <?php if ($message != ""): ?>
        <script>
            Swal.fire({
                title: 'Status',
                text: '<?php echo $message; ?>',
                icon: '<?php echo $status; ?>',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirect back to the form to avoid resubmission on refresh
                    window.location.href = 'tambah_vaksin.php';
                }
            });
        </script>
        <?php
endif; ?>

        <div class="card mt-4">
            <div class="card-body">
                <form action="tambah_vaksin.php" method="post">

                    <div class="form-group">
                        <label for="nama_vaksin">Nama Vaksin: <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nama_vaksin" name="nama_vaksin"
                            placeholder="Masukkan nama vaksin (Contoh: Polio, Campak)" required>
                    </div>

                    <div class="form-group">
                        <label for="stok">Stok: <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="stok" name="stok" placeholder="Jumlah stok"
                            required min="0">
                    </div>

                    <div class="form-group">
                        <label for="satuan">Satuan: <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="satuan" name="satuan"
                            placeholder="Contoh: Dosis, Vial, Kapsul" value="Dosis" required>
                    </div>

                    <div class="form-group">
                        <label for="keterangan">Keterangan Tambahan:</label>
                        <textarea class="form-control" id="keterangan" name="keterangan" rows="3"
                            placeholder="Keterangan (Opsional)"></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan Stok</button>
                    <!-- Tautan ini bisa disesuaikan ke halaman utama atau halaman daftar vaksin nantinya -->
                    <a href="index.php" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
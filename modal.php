<?php
require 'koneksi.php';

// Ambil data dari database untuk tabel modal
$queryModal = mysqli_query($koneksi, "SELECT * FROM modal ORDER BY tanggal DESC");
if (!$queryModal) {
    die('Query Error: ' . mysqli_error($koneksi));
}

// Ambil data dari database untuk tabel kategori_akun
$queryKategori = mysqli_query($koneksi, "SELECT * FROM kategori_akun ORDER BY nama_akun ASC");
if (!$queryKategori) {
    die('Query Error: ' . mysqli_error($koneksi));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Input Modal</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <!-- Form Tambah Modal -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 text-center">
            <h4 class="m-0 font-weight-bold text-primary">Tambah Modal</h4>
        </div>
        <div class="card-body">
            <form method="POST" action="tambah-modal.php">
                <div class="form-group">
                    <label for="tanggal">Tanggal</label>
                    <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                </div>
                <div class="form-group">
                    <label for="nama_akun">Nama Akun</label>
                    <select class="form-control" id="nama_akun" name="nama_akun" required>
                        <option value="">Pilih Nama Akun</option>
                        <?php 
                        while ($kategori = mysqli_fetch_assoc($queryKategori)) { 
                        ?>
                        <option value="<?= $kategori['nama_akun'] ?>"><?= $kategori['nama_akun'] ?></option>
                        <?php 
                        } 
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="nominal">Nominal Saldo</label>
                    <input type="number" class="form-control" id="nominal" name="nominal" required>
                </div>
                <button type="submit" class="btn btn-primary">Tambah</button>
                <a href="index.php" class="btn btn-secondary">Keluar</a>
            </form>
        </div>
    </div>
    <!-- Tabel Data Modal -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Modal</h6>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Tanggal</th>
                  <th>Nama Akun</th>
                  <th>Nominal</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                $no = 1;
                while ($data = mysqli_fetch_assoc($queryModal)) { 
                ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $data['tanggal'] ?></td>
                    <td><?= $data['nama_akun'] ?></td>
                    <td><?= number_format($data['nominal'], 0, ',', '.') ?></td>
                </tr>
                <?php 
                } 
                ?>
              </tbody>
            </table>
          </div>
        </div>
    </div>
</div>
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="js/sb-admin-2.min.js"></script>
</body>
</html>

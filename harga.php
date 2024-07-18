<?php
require 'cek-sesi.php';
require 'koneksi.php';

$currDate = date('Y-m-d');

function convert_time($time)
{
  if ($time < 24) {
    return "$time Jam";
  } else {
    $days = $time / 24;
    return round($days) . " Hari";
  }
}

// Ambil merek untuk menu dropdown
$mobil_query = mysqli_query($koneksi, "SELECT id_mobil, nama FROM mobil");
if (!$mobil_query) {
    die('Query Error: ' . mysqli_error($koneksi));
}
$mobils = [];
while ($mobil = mysqli_fetch_assoc($mobil_query)) {
    $mobils[] = $mobil;
}
?> 
<!DOCTYPE html> 
<html lang="en"> 
<head> 
    <meta charset="utf-8"> 
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> 
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> 
    <meta name="description" content=""> 
    <meta name="author" content=""> 
    <title>SIA KAS GC PERSADA</title> 
    <!-- Font khusus untuk template ini -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css"> 
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet"> 
    <!-- Gaya khusus untuk template ini --> 
    <link href="css/sb-admin-2.min.css" rel="stylesheet"> 
    <!-- Gaya khusus untuk halaman ini --> 
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet"> 
</head> 
<body id="page-top"> 
    <?php 
    $role = $_SESSION['role_id']; 
    $role == '3' ? require('sidebar-karyawan.php') : require('sidebar.php'); 
    ?> 
    <!-- Konten Utama --> 
    <div id="content"> 
        <?php require 'navbar.php'; ?> 
        <!-- Awal Konten Halaman --> 
        <div class="container-fluid"> 
            <button type="button" class="btn btn-success" style="margin:5px" data-toggle="modal" data-target="#myModalTambah"><i class="fa fa-plus"></i> Tambah Harga</button><br> 
            <!-- Contoh DataTales --> 
            <div class="card shadow mb-4"> 
                <div class="card-header py-3"> 
                    <h6 class="m-0 font-weight-bold text-primary">Daftar Harga</h6> 
                </div> 
                <div class="card-body"> 
                    <div class="table-responsive"> 
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0"> 
                            <thead> 
                                <tr> 
                                    <th>No</th> 
                                    <th>Nama</th> 
                                    <th>Paket</th> 
                                    <th>Lama sewa</th>
                                    <th>Harga</th> 
                                    <th>Uang Muka</th> 
                                    <th>Status</th> 
                                    <th>Aksi</th> 
                                </tr> 
                            </thead> 
                            <tbody> 
                                <?php      
                                $no = 1; // Inisialisasi penghitung 
                                    $query = mysqli_query($koneksi, "
                                        SELECT harga.*, mobil.nama, mobil.status AS status_mobil 
                                        FROM harga 
                                        JOIN mobil ON harga.id_mobil = mobil.id_mobil 
                                        ORDER BY status_mobil DESC
                                    ");

                                    if (!$query) {
                                die('Query Error: ' . mysqli_error($koneksi)); 
                                    }
                                    while ($data = mysqli_fetch_assoc($query)) { 
                                   
                                ?> 
                                <tr> 
                                    <td><?= $no++ ?></td> <!-- Menambah penghitung --> 
                                    <td><?= $data['nama'] ?></td> 
                                    <td><?= $data['jenis_paket'] ?></td> 
                                    <td><?= $data['lama_sewa'] ?></td> 
                                    <td><?= $data['harga'] ?></td>
                                    <td><?= $data['harga'] / 2 ?></td> <!-- Kolom untuk menampilkan uang muka -->

                                    <td> 
                                      <!-- Menampilkan Status yang Diperbarui --> 
                                        <?php 
                                        if ($data['status'] == 1) { 
                                            echo '<span class="badge badge-pill badge-success"><i class="fa fa-check"></i> Tersedia</span>'; 
                                        } else { 
                                            echo '<span class="badge badge-pill badge-warning text-dark"><i class="fa fa-circle-xmark"></i> Tidak Tersedia</span>'; 
                                        } 
                                        ?> 
                                    </td> 
                                    <td> <!-- Tombol untuk modal --> 
                                        <a href="#" type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal<?= $data['id_harga']; ?>"><i class="fa fa-edit"></i> Edit</a> 
                                    </td> 
                                </tr> 
                                <!-- Edit Modal --> 
                                <div class="modal fade" id="myModal<?= $data['id_harga']; ?>" role="dialog"> 
                                    <div class="modal-dialog"> <!-- Konten modal--> 
                                        <div class="modal-content"> 
                                            <div class="modal-header"> 
                                                <h4 class="modal-title">Ubah Data Harga</h4> 
                                                <button type="button" class="close" data-dismiss="modal">×</button> 
                                            </div> 
                                            <div class="modal-body"> 
                                                <form role="form" action="proses-edit-harga.php" method="post"> 
                                                    <?php 
                                                    $id = $data['id_harga']; 
                                                    $query_edit = mysqli_query($koneksi, "SELECT * FROM harga WHERE id_harga='$id'"); 
                                                    if (!$query_edit) {
                                                        die('Query Error: ' . mysqli_error($koneksi));
                                                    }
                                                    $row = mysqli_fetch_array($query_edit); 
                                                    ?> 
                                                    <input type="hidden" name="id_harga" value="<?= $row['id_harga']; ?>"> 
                                                    <div class="form-group"> 
                                                        <label>Nama</label> 
                                                        <select name="id_mobil" class="form-control"> 
                                                            <?php 
                                                            foreach ($mobils as $mobil) { 
                                                            ?> 
                                                            <option value="<?= $mobil['id_mobil']; ?>" <?= ($row['id_mobil'] == $mobil['id_mobil']) ? 'selected' : ''; ?>><?= $mobil['nama']; ?></option> 
                                                            <?php 
                                                            } 
                                                            ?> 
                                                        </select> 
                                                    </div> 
                                                    <div class="form-group"> 
                                                        <label>Paket</label> 
                                                        <select name="jenis_paket" class="form-control"> 
                                                            <option value="Lepas Kunci" <?= ($row['jenis_paket'] == 'Lepas Kunci') ? 'selected' : ''; ?>>Lepas Kunci</option> 
                                                            <option value="Paket Komplit" <?= ($row['jenis_paket'] == 'Paket Komplit') ? 'selected' : ''; ?>>Paket Komplit</option> 
                                                        </select> 
                                                    </div> 
                                                    <div class="form-group"> 
                                                        <label>Lama Sewa</label> 
                                                        <select name="lama_sewa" class="form-control"> 
                                                            <option value="12" <?= ($row['lama_sewa'] == 12) ? 'selected' : ''; ?>>12 Jam</option> 
                                                            <option value="18" <?= ($row['lama_sewa'] == 18) ? 'selected' : ''; ?>>18 Jam</option> 
                                                            <option value="24" <?= ($row['lama_sewa'] == 24) ? 'selected' : ''; ?>>24 Jam</option> 
                                                            <option value="48" <?= ($row['lama_sewa'] == 48) ? 'selected' : ''; ?>>2 Hari</option> 
                                                            <option value="72" <?= ($row['lama_sewa'] == 72) ? 'selected' : ''; ?>>3 Hari</option> 
                                                            <option value="96" <?= ($row['lama_sewa'] == 96) ? 'selected' : ''; ?>>4 Hari</option> 
                                                            <option value="120" <?= ($row['lama_sewa'] == 120) ? 'selected' : ''; ?>>5 Hari</option> 
                                                            <option value="144" <?= ($row['lama_sewa'] == 144) ? 'selected' : ''; ?>>6 Hari</option> 
                                                            <option value="168" <?= ($row['lama_sewa'] == 168) ? 'selected' : ''; ?>>7 Hari</option> 
                                                        </select> 
                                                    </div> 
                                                    <div class="form-group"> 
                                                        <label>Harga</label> 
                                                        <input type="text" name="harga" class="form-control" value="<?= $row['harga']; ?>"> 
                                                    </div> 
                                                    <div class="modal-footer"> 
                                                        <button type="submit" class="btn btn-success">Ubah</button> 
                                                        <a href="hapus-harga.php?id_harga=<?= $row['id_harga']; ?>" onclick="return confirm('Anda Ingin Menghapus?')" class="btn btn-danger">Hapus</a> 
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Keluar</button> 
                                                    </div> 
                                                </form> 
                                            </div> 
                                        </div> 
                                    </div> 
                                </div> 
                                <?php 
                                } 
                                ?> 
                            </tbody> 
                        </table> 
                    </div> 
                </div> 
            </div> 
            <!-- Tambah Modal --> 
            <div id="myModalTambah" class="modal fade" role="dialog"> 
                <div class="modal-dialog"> 
                    <!-- konten modal--> 
                    <div class="modal-content"> 
                        <!-- heading modal --> 
                        <div class="modal-header"> 
                            <h4 class="modal-title">Tambah Harga</h4> 
                            <button type="button" class="close" data-dismiss="modal">×</button> 
                        </div> 
                        <!-- body modal --> 
                        <form action="tambah-harga.php" method="POST">
                            <div class="modal-body">
                                <div class="form-group">
                                <label>Nama</label>
                                <select name="id_mobil" class="form-control" required>
                                    <?php foreach ($mobils as $mobil) { ?>
                                    <option value="<?= $mobil['id_mobil']; ?>"><?= $mobil['nama']; ?></option>
                                    <?php } ?>
                                </select>
                                </div>
                                <div class="form-group">
                                <label>Paket</label>
                                <select name="jenis_paket" class="form-control">
                                    <option value="Lepas Kunci">Lepas Kunci</option>
                                    <option value="Paket Komplit">Paket Komplit</option>
                                </select>
                                </div>
                                <div class="form-group">
                                <label>Lama Sewa</label>
                                <select name="lama_sewa" class="form-control">
                                    <option value="12">12 Jam</option>
                                    <option value="18">18 Jam</option>
                                    <option value="24">24 Jam</option>
                                    <option value="48">2 Hari</option>
                                    <option value="72">3 Hari</option>
                                    <option value="96">4 Hari</option>
                                    <option value="120">5 Hari</option>
                                    <option value="144">6 Hari</option>
                                    <option value="168">7 Hari</option>
                                </select>
                                </div>
                                <div class="form-group">
                                <label>Harga</label>
                                <input type="number" class="form-control" name="harga" required>
                                </div>
                                <input type="hidden" name="status" value="1">
                            </div>
                            <!-- modal footer --> 
                            <div class="modal-footer"> 
                                <button type="submit" class="btn btn-success">Tambah</button> 
                                <button type="button" class="btn btn-default" data-dismiss="modal">Keluar</button> 
                            </div> 
                        </form> 
                    </div> 
                </div> 
            </div> 
        </div> 
        <!-- /.container-fluid --> 
    </div> 
    <!-- End of Main Content -->

  <?php require 'footer.php' ?>

</div>
<!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
  <i class="fas fa-angle-up"></i>
</a>

<!-- Bootstrap core JavaScript-->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="js/sb-admin-2.min.js"></script>

<!-- Page level plugins -->
<script src="vendor/datatables/jquery.dataTables.min.js"></script>
<script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

<!-- Page level custom scripts -->
<script src="js/demo/datatables-demo.js"></script>

</body>

</html>

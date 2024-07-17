<?php
session_start();
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
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <link href="css/sb-admin-2.min.css" rel="stylesheet">
  <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
</head>

<body id="page-top">

  <?php
  require 'koneksi.php';
  require('sidebar.php');
  ?>

  <?php
  $query = mysqli_query($koneksi, "SELECT pendapatan_sewa.*, kategori_akun.nama_akun, pelanggan.nama FROM pendapatan_sewa JOIN kategori_akun ON pendapatan_sewa.id_akun=kategori_akun.id_akun JOIN pelanggan ON pelanggan.id_pelanggan = pendapatan_sewa.id_pelanggan");
  while ($data = mysqli_fetch_assoc($query))
  ?>
  <div id="content">
  <?php require 'navbar.php'; ?>
    <div class="container-fluid">
      <button type="button" class="btn btn-success" style="margin:5px" data-toggle="modal" data-target="#myModalTambah"><i class="fa fa-plus"></i> Tambah Operasional</button><br>

      <!-- Modal Tambah Operasional -->
      <div class="modal fade" id="myModalTambah" role="dialog">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-body">
                      <form role="form" action="tambah-operasional.php" method="post">
                          <div class="form-group">
                              <label>Akun</label>
                              <select name="id_akun" class="form-control" required>
                                  <?php
                                  $queryKategori = mysqli_query($koneksi, "SELECT * FROM kategori_akun");
                                  while ($kategori = mysqli_fetch_assoc($queryKategori)) {
                                      echo "<option value='{$kategori['id_akun']}'>{$kategori['nama_akun']}</option>";
                                  }
                                  ?>
                              </select>
                          </div>
                          <div class="form-group">
                              <label>Nama Operasional</label>
                              <input type="text" name="nama_operasional" class="form-control" required>
                          </div>
                          <div class="form-group">
                              <label>Tanggal Operasional</label>
                              <input type="date" name="tanggal_operasional" class="form-control" required>
                          </div>
                          <div class="form-group">
                              <label>Harga</label>
                              <input type="number" name="harga" class="form-control" required>
                          </div>
                          <div class="form-group">
                              <label>Kuantitas</label>
                              <input type="number" name="kuantitas" class="form-control" required>
                          </div>
                          <div class="modal-footer">
                              <button type="submit" class="btn btn-success">Tambah</button>
                              <button type="button" class="btn btn-default" data-dismiss="modal">Keluar</button>
                          </div>
                      </form>
                  </div>
              </div>
          </div>
      </div>

      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h5 class="m-0 font-weight-bold text-primary">Daftar Biaya Operasional</h5>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th width="15%">Akun</th>
                  <th width="20%">Nama Operasional</th>
                  <th width="15%">Tanggal Operasional</th>
                  <th width="15%">Harga</th>
                  <th width="5%">Kuantitas</th>
                  <th width="13%">Total Operasional</th>
                  <th width="8%">Aksi</th>
                </tr>
              </thead>
              <tbody> 
                <?php
                $query = mysqli_query($koneksi, "SELECT * FROM operasional");
                while ($data = mysqli_fetch_assoc($query)) {
                ?>
                  <tr>
                    <td><?= $data['id_akun'] ?></td>
                    <td><?= $data['nama_operasional'] ?></td>
                    <td><?= $data['tanggal_operasional'] ?></td>
                    <td>Rp. <?= number_format($data['harga'], 2, ',', '.'); ?></td>
                    <td><?= $data['kuantitas'] ?></td>
                    <td>Rp. <?= number_format($data['total_operasional'], 2, ',', '.'); ?></td>
                    <td>
                      <a href="#" class=" btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal<?= $data['id_operasional']; ?>"><i class="fa fa-edit"></i> Edit</a>
                    </td>
                  </tr>

                  <!-- Modal Edit Operasional -->
                  <div class="modal fade" id="myModal<?= $data['id_operasional']; ?>" role="dialog">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">Ubah Data Operasional</h4>
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                          <form role="form" action="proses-edit-operasional.php" method="get">
                            <?php
                            $id = $data['id_operasional'];
                            $query_edit = mysqli_query($koneksi, "SELECT * FROM operasional WHERE id_operasional='$id'");
                            while ($row = mysqli_fetch_array($query_edit)) {
                            ?>
                              <input type="hidden" name="id_operasional" value="<?= $row['id_operasional']; ?>">
                              <div class="form-group">
                                <label>Id Operasional</label>
                                <input type="text" name="id_operasional" class="form-control" value="<?= $row['id_operasional']; ?>" disabled>
                              </div>
                              <div class="form-group">
                                <label>Akun</label>
                                <select name="id_akun" class="form-control" required>
                                  <?php
                                  $queryKategori = mysqli_query($koneksi, "SELECT * FROM kategori_akun");
                                  while ($kategori = mysqli_fetch_assoc($queryKategori)) {
                                    $selected = ($kategori['id_akun'] == $row['id_akun']) ? 'selected' : '';
                                    echo "<option value='{$kategori['id_akun']}' $selected>{$kategori['nama_akun']}</option>";
                                  }
                                  ?>
                                </select>
                              </div>
                              <div class="form-group">
                                <label>Nama_operasional</label>
                                <input type="text" name="nama_operasional" class="form-control" value="<?= $row['nama_operasional']; ?>">
                              </div>
                              <div class="form-group">
                                <label>Tanggal Operasional</label>
                                <input type="date" name="tanggal_operasional" class="form-control" value="<?= $row['tanggal_operasional']; ?>">
                              </div>
                              <div class="form-group">
                                <label>Harga</label>
                                <input type="number" name="harga" class="form-control" value="<?= $row['harga']; ?>">
                              </div>
                              <div class="form-group">
                                <label>Kuantitas</label>
                                <input type="number" name="kuantitas" class="form-control" value="<?= $row['kuantitas']; ?>">
                              </div>
                              <div class="modal-footer">
                                <button type="submit" class="btn btn-success">Ubah</button>
                                <a href="hapus-operasional.php?id_operasional=<?= $row['id_operasional']; ?>" onclick="return confirm('Anda Yakin Ingin Menghapus?')" class="btn btn-danger">Hapus</a>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Keluar</button>
                              </div>
                            <?php
                            }
                            ?>
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
    </div>

  </div>
  </div>
  </div>

  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="js/sb-admin-2.min.js"></script>
  <script src="vendor/chart.js/Chart.min.js"></script>
  <script src="vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
  <script src="js/demo/datatables-demo.js"></script>

</body>

</html>
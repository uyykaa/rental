<?php
require 'cek-sesi.php';
require 'koneksi.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="shortcut icon" href="img/logo.jpg">
  <title>SIA GC PERSADA</title>
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <link href="css/sb-admin-2.min.css" rel="stylesheet">
  <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
</head>

<body id="page-top">
  <?php require 'sidebar.php'; ?>
  <?php require 'navbar.php'; ?>
  <div id="content">

    <!-- Begin Page Content -->
    <div class="container-fluid">
      <button type="button" class="btn btn-success" style="margin:5px" data-toggle="modal" data-target="#myModalTambah"><i class="fa fa-plus"> Pendapatan Sewa</i></button><br>

      <!-- DataTales Example -->
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">Daftar Pendapatan</h6>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>No Pendapatan</th>
                  <th>Nama Akun</th>
                  <th>Nama Pelanggan</th>
                  <th>Tanggal Pendapatan</th>
                  <th>Jumlah Pendapatan</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 0;
                $total_pendapatan = 0;
                $query = mysqli_query($koneksi, "SELECT pendapatan_sewa.*, kategori_akun.nama_akun, pelanggan.nama FROM pendapatan_sewa JOIN kategori_akun ON pendapatan_sewa.id_akun=kategori_akun.id_akun JOIN pelanggan ON pelanggan.no_pelanggan = pendapatan_sewa.no_pelanggan");
                while ($data = mysqli_fetch_assoc($query)) {
                  $total_pendapatan += $data['jumlah_pendapatan'];
                ?>
                  <tr>
                    <td><?= $no += 1; ?></td>
                    <td><?= $data['nama_akun'] ?></td>
                    <td><?= $data['nama'] ?></td>
                    <td><?= $data['tgl_pendapatan'] ?></td>
                    <td><?= number_format($data['jumlah_pendapatan'], 2) ?></td>
                    <td>
                      <a href="#" type="button" class="fa fa-edit btn btn-primary btn-md" data-toggle="modal" data-target="#myModal<?= $data['id_pendapatan']; ?>"> Edit</a>
                    </td>
                  </tr>
                  <!-- Modal Edit -->
                  <div class="modal fade" id="myModal<?= $data['id_pendapatan']; ?>" role="dialog">
                    <div class="modal-dialog">
                      <!-- Modal content-->
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">Ubah Data Pendapatan </h4>
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                          <form role="form" action="proses-edit-pendapatan-sewa.php" method="post">
                            <?php
                            $id = $data['id_pendapatan'];
                            $query_edit = mysqli_query($koneksi, "SELECT * FROM pendapatan_sewa WHERE id_pendapatan='$id'");
                            while ($row = mysqli_fetch_array($query_edit)) {
                            ?>
                              <input type="hidden" name="id_pendapatan" value="<?= $row['id_pendapatan']; ?>">
                              <div class="form-group">
                                <label>Akun</label>
                                <select name="id_akun" class="form-control">
                                  <?php
                                  $akun_query = mysqli_query($koneksi, "SELECT * FROM kategori_akun");
                                  while ($akun = mysqli_fetch_assoc($akun_query)) {
                                  ?>
                                    <option value="<?= $akun['id_akun']; ?>" <?= $row['id_akun'] == $akun['id_akun'] ? 'selected' : '' ?>><?= $akun['nama_akun']; ?></option>
                                  <?php
                                  }
                                  ?>
                                </select>
                              </div>
                              <div class="form-group">
                                <label>Nama Pelanggan</label>
                                <select name="no_pelanggan" class="form-control">
                                  <?php
                                  $pelanggan_query = mysqli_query($koneksi, "SELECT * FROM pelanggan");
                                  while ($pelanggan = mysqli_fetch_assoc($pelanggan_query)) {
                                  ?>
                                    <option value="<?= $pelanggan['no_pelanggan']; ?>" <?= ($row['no_pelanggan'] == $pelanggan['no_pelanggan']) ? 'selected' : ''; ?>><?= $pelanggan['nama']; ?></option>
                                  <?php
                                  }
                                  ?>
                                </select>
                              </div>
                              <div class="form-group">
                                <label>Tanggal Pendapatan</label>
                                <input type="date" name="tgl_pendapatan" class="form-control" value="<?= $row['tgl_pendapatan']; ?>">
                              </div>
                              <div class="form-group">
                                <label>Jumlah</label>
                                <input type="number" name="jumlah_pendapatan" class="form-control" value="<?= $row['jumlah_pendapatan']; ?>">
                              </div>
                              <div class="modal-footer">
                                <button type="submit" class="btn btn-success">Ubah</button>
                                <a href="hapus-pendapatan.php?id_pendapatan=<?= $row['id_pendapatan']; ?>" onclick="return confirm('Anda Yakin Ingin Menghapus?')" class="btn btn-danger">Hapus</a>
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
                <?php } ?>
                <!-- Baris Total -->
                <tr>
                  <td colspan="4"><strong>Total Pendapatan</strong></td>
                  <td><strong><?= number_format($total_pendapatan, 2) ?></strong></td>
                  <td></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- Modal Tambah -->
      <div id="myModalTambah" class="modal fade" role="dialog">
        <div class="modal-dialog">
          <!-- konten modal-->
          <div class="modal-content">
            <!-- heading modal -->
            <div class="modal-header">
              <h4 class="modal-title">Tambah Pendapatan</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- body modal -->
            <form action="tambah-pendapatan-sewa.php" method="POST">
              <div class="modal-body ">
                Nama Akun :
                <select name="id_akun" class="form-control mb-4">
                  <?php
                  $akun_query = mysqli_query($koneksi, "SELECT * FROM kategori_akun");
                  while ($akun = mysqli_fetch_assoc($akun_query)) {
                  ?>
                    <option value="<?= $akun['id_akun']; ?>" selected><?= $akun['nama_akun']; ?></option>
                  <?php
                  }
                  ?>
                </select>

                Nama Pelanggan :
                <select name="no_pelanggan" class="form-control mb-4">
                  <option value="-">pilih nama pelanggan...</option>
                  <?php
                  $pelanggan_query = mysqli_query($koneksi, "SELECT * FROM pelanggan");
                  while ($pelanggan = mysqli_fetch_assoc($pelanggan_query)) {
                  ?>
                    <option value="<?= $pelanggan['no_pelanggan']; ?>"><?= $pelanggan['nama']; ?></option>
                  <?php
                  }
                  ?>
                </select>

                Tanggal Sewa :
                <select name="id_sewa" class="form-control mb-4">
                  <option value="-">pilih tanggal sewa...</option>
                  <?php
                  $jumlah_sewa = 0;
                  $sewa_query = mysqli_query($koneksi, "SELECT * FROM sewa_kendaraan");
                  while ($sewa = mysqli_fetch_assoc($sewa_query)) {
                  ?>
                    <option value="<?= $sewa['id_sewa']; ?>"><?php $queryNama = mysqli_query($koneksi, 'SELECT * FROM pelanggan');
                                                              while ($namaPelanggan = mysqli_fetch_assoc($queryNama)) {
                                                                if ($sewa['no_pelanggan'] === $namaPelanggan['no_pelanggan']) {

                                                                  echo $sewa['tgl_sewa'];
                                                                  echo "  ";
                                                                  echo $namaPelanggan['nama'];
                                                                  $jumlah_sewa = $sewa['total_harga'];
                                                                }
                                                              }
                                                              ?></option>
                  <?php
                  }
                  ?>
                </select>

                Tgl Pendapatan:
                <input type="date" class="form-control mb-4" name="tgl_pendapatan" required>
                Jumlah Pendapatan :
                <input type="number" class="form-control mb-4" name="jumlah_pendapatan" required>
              </div>
              <!-- footer modal -->
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

    <?php require 'footer.php'; ?>
  </div>
  <!-- End of Main Content -->


  <!-- </div> -->
  <!-- End of Content Wrapper -->

  <!-- </div> -->
  <!-- End of Page Wrapper -->


  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="js/sb-admin-2.min.js"></script>
  <script src="vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
  <script src="js/demo/datatables-demo.js"></script>

</body>
<!-- Scroll to Top Button-->

</html>
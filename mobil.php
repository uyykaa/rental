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

// Fetch brands for the dropdown menu
$brands_query = mysqli_query($koneksi, "SELECT id_merek, merek FROM merek");
$brands = [];
while ($brand = mysqli_fetch_assoc($brands_query)) {
  $brands[] = $brand;
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

  <!-- Custom fonts for this template -->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

  <!-- Custom styles for this page -->
  <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
</head>

<body id="page-top">
  <?php $role = $_SESSION['role_id'];
  $role == '3' ? require('sidebar-karyawan.php') : require('sidebar.php') ?>
  <!-- Main Content -->
  <div id="content">
    <?php require 'navbar.php'; ?>

    <!-- Begin Page Content -->
    <div class="container-fluid">
      <button type="button" class="btn btn-success" style="margin:5px" data-toggle="modal" data-target="#myModalTambah"><i class="fa fa-plus"></i> Tambah Mobil</button><br>

      <!-- DataTales Example -->
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">Daftar Mobil</h6>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Merek</th>
                  <th>Nama</th>
                  <th>Warna</th>
                  <th>No Polisi</th>
                  <th>Kursi</th>
                  <th>Status</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 1; // Initialize the counter
                $query = mysqli_query($koneksi, "SELECT mobil.*, merek.merek FROM mobil JOIN merek ON mobil.id_merek = merek.id_merek order by status desc");
                while ($data = mysqli_fetch_assoc($query)) {
                ?>
                  <tr>
                    <td><?= $no++ ?></td> <!-- Increment the counter -->
                    <td><?= $data['merek'] ?></td>
                    <td><?= $data['nama'] ?></td>
                    <td><?= $data['warna'] ?></td>
                    <td><?= $data['no_polisi'] ?></td>
                    <td><?= $data['jumlah_set'] ?></td>
                    <td>
                      <!-- Updated Status Display -->
                      <?php
                      if ($data['status'] == 1) {
                        echo '<span class="badge badge-pill badge-success"><i class="fa fa-check"></i> Tersedia</span>';;
                      } else {
                        echo '<span class="badge badge-pill badge-warning text-dark"><i class="fa fa-circle-xmark"></i> Tidak Tersedia</span>';
                      }
                      ?>
                    </td>
                    <td>
                      <!-- Button for modal -->
                      <a href="#" type="button" class=" btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal<?= $data['id_mobil']; ?>"><i class="fa fa-edit"></i> Edit</a>
                    </td>
                  </tr>
                  <!-- Modal Edit -->
                  <div class="modal fade" id="myModal<?= $data['id_mobil']; ?>" role="dialog">
                    <div class="modal-dialog">
                      <!-- Modal content-->
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">Ubah Data Mobil</h4>
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                          <form role="form" action="proses-edit-mobil.php" method="post">
                            <?php
                            $id = $data['id_mobil'];
                            $query_edit = mysqli_query($koneksi, "SELECT * FROM mobil WHERE id_mobil='$id'");
                            while ($row = mysqli_fetch_array($query_edit)) {
                            ?>
                              <input type="hidden" name="id_mobil" value="<?= $row['id_mobil']; ?>">
                              <div class="form-group">
                                <label>Merek</label>
                                <select name="id_merek" class="form-control">
                                  <?php foreach ($brands as $brand) { ?>
                                    <option value="<?= $brand['id_merek']; ?>" <?= ($row['id_merek'] == $brand['id_merek']) ? 'selected' : ''; ?>><?= $brand['merek']; ?></option>
                                  <?php } ?>
                                </select>
                              </div>
                              <div class="form-group">
                                <label>Nama</label>
                                <input type="text" name="nama" class="form-control" value="<?= $row['nama']; ?>">
                              </div>
                              <div class="form-group">
                                <label>Warna</label>
                                <input type="text" name="warna" class="form-control" value="<?= $row['warna']; ?>">
                              </div>
                              <div class="form-group">
                                <label>No Polisi</label>
                                <input type="text" name="no_polisi" class="form-control" value="<?= $row['no_polisi']; ?>">
                              </div>
                              <div class="form-group">
                                <label>Kursi</label>
                                <select name="jumlah_set" class="form-control">
                                  <option value="2" <?= ($row['jumlah_set'] == 2) ? 'selected' : ''; ?>>2</option>
                                  <option value="4" <?= ($row['jumlah_set'] == 4) ? 'selected' : ''; ?>>4</option>
                                  <option value="5" <?= ($row['jumlah_set'] == 5) ? 'selected' : ''; ?>>5</option>
                                  <option value="7" <?= ($row['jumlah_set'] == 7) ? 'selected' : ''; ?>>7</option>
                                  <option value="8" <?= ($row['jumlah_set'] == 8) ? 'selected' : ''; ?>>8</option>
                                  <option value="12" <?= ($row['jumlah_set'] == 12) ? 'selected' : ''; ?>>12</option>
                                  <option value="16" <?= ($row['jumlah_set'] == 16) ? 'selected' : ''; ?>>16</option>
                                </select>
                              </div>
                              <div class="modal-footer">
                                <button type="submit" class="btn btn-success">Ubah</button>
                                <a href="hapus-mobil.php?id_mobil=<?= $row['id_mobil']; ?>" onclick="return confirm('Anda Yakin Ingin Menghapus?')" class="btn btn-danger">Hapus</a>
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

      <!-- Modal Tambah -->
      <div id="myModalTambah" class="modal fade" role="dialog">
        <div class="modal-dialog">
          <!-- konten modal-->
          <div class="modal-content">
            <!-- heading modal -->
            <div class="modal-header">
              <h4 class="modal-title">Tambah Mobil</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- body modal -->
            <form action="tambah-mobil.php" method="POST">
              <div class="modal-body">
                <div class="form-group">
                  <label>Merek</label>
                  <select name="id_merek" class="form-control" required>
                    <?php foreach ($brands as $brand) { ?>
                      <option value="<?= $brand['id_merek']; ?>"><?= $brand['merek']; ?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="form-group">
                  <label>Nama</label>
                  <input type="text" class="form-control" name="nama" required>
                </div>
                <div class="form-group">
                  <label>Warna</label>
                  <input type="text" class="form-control" name="warna" required>
                </div>
                <div class="form-group">
                  <label>No Polisi</label>
                  <input type="text" class="form-control" name="no_polisi" required>
                </div>
                <div class="form-group">
                  <label>Kursi</label>
                  <select name="jumlah_set" class="form-control" required>
                    <option value="2">2</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="12">12</option>
                    <option value="16">16</option>
                    <!-- Add more options as needed -->
                  </select>
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
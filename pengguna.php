<?php
session_start();
if ($_SESSION['role_id'] != '2') {
  header("location:logout.php?pesan=gagal");
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


  <!-- Custom styles for this template -->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

  <!-- Custom styles for this page -->
  <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body id="page-top">
  <?php
  require 'koneksi.php';
  require 'sidebar-pemilik.php';
  ?>

  <!-- Main Content -->
  <div id="content">
    <?php require 'navbar.php';
    ?>

    <!-- Begin Page Content -->
    <div class="container-fluid">
      <button type="button" class="btn btn-success" style="margin:5px; visibility:<?= $lihat ?>" data-toggle="modal" data-target="#myModalTambah"><i class="fa fa-plus"></i> User</button><br>

      <!-- DataTales Example -->
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">Kelola Pengguna</h6>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama</th>
                  <th>Jabatan</th>
                  <th>Alamat</th>
                  <th>Email</th>
                  <th>No. Handphone</th>
                  <th>Status</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tfoot>
              </tfoot>
              <tbody>
                <?php
                $no = 0;
                $query = mysqli_query($koneksi, "SELECT * FROM users ORDER BY status desc");
                while ($data = mysqli_fetch_assoc($query)) {
                ?>
                  <tr>
                    <td><?= $no += 1; ?></td>
                    <td><?= $data['nama'] ?></td>
                    <td><?= $data['jabatan'] ?></td>
                    <td style="word-wrap: break-word;"><?= $data['alamat'] ?></td>
                    <td><?= $data['email'] ?></td>
                    <td><?= $data['no_hp'] ?></td>
                    <td><?= $data['status'] == '1' ? '<span class="badge badge-success">Aktif</span>' : '<span class="badge badge-secondary">Tidak Aktif</span>' ?></td>
                    <td>

                      <!-- Button untuk modal -->
                      <a href="#" type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal<?php echo $data['id']; ?>"><i class="fa fa-edit"></i> Edit data</a>
                      <a href="#" type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalPass<?php echo $data['id']; ?>"><i class="fa fa-edit"></i> Edit Password</a>
                    </td>
                  </tr>

                  <div class="modal fade" id="myModal<?php echo $data['id']; ?>" role="dialog">
                    <div class="modal-dialog">

                      <!-- Modal content-->
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">Ubah Data Pengguna</h4>
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                          <form role="form" action="proses-edit-pengguna.php" method="POST">

                            <?php
                            $id = $data['id'];
                            $query_edit = mysqli_query($koneksi, "SELECT * FROM users WHERE id='$id'");
                            //$result = mysqli_query($conn, $query);
                            while ($row = mysqli_fetch_array($query_edit)) {
                            ?>

                              <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

                              <div class="form-group">
                                <label>Nama</label>
                                <input type="text" name="nama" class="form-control" value="<?php echo $row['nama']; ?>" required>
                              </div>

                              <div class="form-group">
                                <label>Jabatan</label>
                                <select name="jabatan" class="form-control">
                                  <option value="<?= $row['jabatan']; ?>" selected><?= $row['jabatan'] ?></option>
                                  <option value="pemilik">Pemilik</option>
                                  <option value="karyawan">Karyawan</option>
                                  <option value="keuangan">Keuangan</option>
                                </select>
                              </div>

                              <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" value="<?php echo $row['email']; ?>" required>
                              </div>

                              <div class="form-group">
                                <label>No. Handphone</label>
                                <input type="number" name="no_hp" class="form-control" value="<?php echo $row['no_hp']; ?>" required>
                              </div>

                              <div class="form-group">
                                <label>Alamat</label>
                                <textarea type="text" name="alamat" class="form-control" required><?php echo $row['alamat']; ?></textarea>
                              </div>

                              <div class="form-group">
                                <label>Status</label>
                                <select name="status" class="form-control">
                                  <option value="1" selected>Aktif</option>
                                  <option value="0">Tidak Aktif</option>
                                </select>
                              </div>

                              <div class="modal-footer">
                                <button type="submit" class="btn btn-success"><i class="fa fa-paper-plane"></i> Ubah</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Keluar</button>
                              </div>
                            <?php
                            }
                            //mysql_close($host);
                            ?>

                          </form>
                        </div>
                      </div>

                    </div>
                  </div>


                  <div class="modal fade" id="modalPass<?php echo $data['id']; ?>" role="dialog">
                    <div class="modal-dialog">

                      <!-- Modal content-->
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">Ubah Password Pengguna</h4>
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                          <form role="form" action="proses-edit-pass-pengguna.php" method="POST">

                            <?php
                            $id = $data['id'];
                            $query_edit = mysqli_query($koneksi, "SELECT * FROM users WHERE id='$id'");
                            //$result = mysqli_query($conn, $query);
                            while ($row = mysqli_fetch_array($query_edit)) {
                            ?>

                              <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

                              <div class="form-group">
                                <label>Password Baru</label>
                                <input type="password" name="password" id="password" class="form-control" required>
                              </div>

                              <div class="form-group">
                                <label>Konfirmasi Password</label>
                                <input type="password" name="konfirmasi_password" id="konfirmasi_password" class="form-control" required onchange="myFunction()">
                                <span class="text-danger" id='notif_pass'></span>
                              </div>

                              <div class="modal-footer">
                                <button type="submit" class="btn btn-success"><i class="fa fa-paper-plane"></i> Ubah</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Keluar</button>
                              </div>
                            <?php
                            }
                            //mysql_close($host);
                            ?>

                          </form>
                        </div>
                      </div>

                    </div>
                  </div>


                  <!-- Modal -->
                  <div id="myModalTambah" class="modal fade" role="dialog">
                    <div class="modal-dialog">

                      <!-- konten modal-->
                      <div class="modal-content">
                        <!-- heading modal -->
                        <div class="modal-header">
                          <h4 class="modal-title">Tambah Pengguna</h4>
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <!-- body modal -->
                        <form action="tambah-pengguna.php" method="POST">
                          <div class="modal-body">
                            Nama :
                            <input type="text" class="form-control" name="nama" required>
                            <div class="form-group">
                              <label>Jabatan</label>
                              <select name="jabatan" class="form-control">
                                <option value="pemilik">Pemilik</option>
                                <option value="karyawan">Karyawan</option>
                                <option value="keuangan">Keuangan</option>
                              </select>
                            </div>
                            Email :
                            <input type="email" class="form-control" name="email" required>
                            Password :
                            <input type="password" class="form-control" name="password" required>
                            No. Handphone :
                            <input type="text" class="form-control" name="no_hp">
                            Alamat :
                            <textarea rows="2" type="text" class="form-control" name="alamat"></textarea>

                          </div>
                          <!-- footer modal -->
                          <div class="modal-footer">
                            <button type="submit" class="btn btn-success">Tambah</button>
                        </form>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Keluar</button>
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
  <!-- /.container-fluid -->
  </div>
  <!-- End of Main Content -->
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
  <script>
    function myFunction() {

      var pass = document.getElementById('password').value;
      var confirm_pass = document.getElementById('konfirmasi_password').value;
      var notif = document.getElementById('notif_pass');

      if (pass != confirm_pass) {
        notif.classList.remove();
        notif.classList.add('text-danger');
        notif.innerHTML = 'Password tidak cocok';
      } else {
        notif.classList.remove('text-danger');
        notif.classList.add('text-success');
        notif.innerHTML = 'password cocok'
      }

    }
  </script>

</body>

</html>
<?php
    require 'cek-sesi.php';
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
    <?php require 'koneksi.php'; ?>
    <?php require 'sidebar.php'; ?>
    <!-- Main Content -->
    <div id="content">

        <?php require 'navbar.php'; ?>

        <!-- Begin Page Content -->
        <div class="container-fluid">

            <button type="button" class="btn btn-success" style="margin:5px" data-toggle="modal" data-target="#myModalTambah"><i class="fa fa-plus"> Akun</i></button><br>

            <div class="modal fade" id="myModalTambah" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Tambah Akun</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <form role="form" action="tambah-kategori.php" method="POST">

                                <div class="form-group">
                                    <label>ID Akun</label>
                                    <input type="text" name="id_akun" class="form-control" placeholder="Masukan Id">
                                </div>
                                <div class="form-group">
                                    <label>Nama Akun</label>
                                    <input type="text" name="nama_akun" class="form-control" placeholder="Masukan Nama">
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-success">Tambah</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Keluar</button>
                                </div>

                            </form>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Modal Edit Kategori -->
            <?php
                // Query untuk mengambil data kategori akun
                $query_kategori = mysqli_query($koneksi, "SELECT * FROM kategori_akun");
                while ($data = mysqli_fetch_assoc($query_kategori)) {
            ?>
                <div class="modal fade" id="myModal<?= $data['id_akun']; ?>" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Ubah Data Akun</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <form role="form" action="proses-edit-kategori.php" method="POST">
                                    <!-- Menyimpan ID Akun -->
                                    <input type="hidden" name="id_akun" value="<?= $data['id_akun']; ?>">
                                    <div class="form-group">
                                        <label>Id Akun</label>
                                        <input type="text" name="id_akun" class="form-control" value="<?= $data['id_akun']; ?>" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label>Nama Akun</label>
                                        <input type="text" name="nama_akun" class="form-control" value="<?= $data['nama_akun']; ?>">
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success">Ubah</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Keluar</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            <?php
                }
            ?>

            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Daftar Akun</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Kode Akun</th>
                                    <th>Nama Akun</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    // Query untuk mengambil data kategori akun
                                    $query_kategori = mysqli_query($koneksi, "SELECT * FROM kategori_akun");
                                    while ($data = mysqli_fetch_assoc($query_kategori)) {
                                ?>
                                    <tr>
                                        <td><?= $data['id_akun'] ?></td>
                                        <td><?= $data['nama_akun'] ?></td>
                                        <td>
                                            <!-- Button for modal -->
                                            <a href="#" type="button" class="fa fa-edit btn btn-primary btn-md" data-toggle="modal" data-target="#myModal<?php echo $data['id_akun']; ?>"> Edit</a>
                                            <!-- Button for modal Hapus -->
                                            <a href="#" type="button" class="fa fa-trash btn btn-danger btn-md" data-toggle="modal" data-target="#modalHapus<?php echo $data['id_akun']; ?>"> Hapus</a>
                                            <!-- Modal Hapus -->
                                            <div class="modal fade" id="modalHapus<?php echo $data['id_akun']; ?>" role="dialog">
                                                <div class="modal-dialog">
                                                    <!-- Modal content-->
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Hapus Data Akun</h4>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>
                                                    <div class="modal-body">
                                                      <p>Apakah Anda yakin ingin menghapus akun ini?</p>
                                                  </div>
                                                <div class="modal-footer">
                                                <a href="hapus-kategori.php?id_akun=<?php echo $data['id_akun']; ?>" class="btn btn-danger">Ya</a>
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Tidak</button>
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
  <?php require 'footer.php' ?>
  </div>

  <!-- End of Content Wrapper -->
  </div>

  <!-- End of Page Wrapper -->
  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
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
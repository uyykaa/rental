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
    require('sidebar.php');
    ?>

    <!-- Main Content -->
    <div id="content">
        <?php require 'navbar.php'; ?>

        <!-- Begin Page Content -->
        <div class="container-fluid">
            <button type="button" class="btn btn-success" style="margin:5px; visibility:<?= $lihat ?>" data-toggle="modal" data-target="#myModalTambah"><i class="fa fa-plus">Tambah Pelanggan</i></button><br>

            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Daftar Pelanggan</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No </th>
                                    <th>Nama pelanggan</th>
                                    <th>Alamat</th>
                                    <th>Kontak</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tfoot>
                            </tfoot>
                            <tbody>
                                <?php
                                $query = mysqli_query($koneksi, "SELECT * FROM pelanggan");
                                $no = 1;
                                while ($data = mysqli_fetch_assoc($query)) {
                                ?>
                                    <tr>
                                        <td><?= $data['no_pelanggan'] ?></td>
                                        <td><?= $data['nama'] ?></td>
                                        <td><?= $data['alamat'] ?></td>
                                        <td><?= $data['no_hp'] ?></td>
                                        <td>
                                            <!-- Button untuk modal -->
                                            <a href="#" type="button" class="fa fa-edit btn btn-primary btn-md" data-toggle="modal" data-target="#myModal<?= $data['no_pelanggan'] ?>"></a>
                                        </td>
                                    </tr>

                                    <!-- Modal -->
                                    <div class="modal fade" id="myModal<?= $data['no_pelanggan'] ?>" role="dialog">
                                        <div class="modal-dialog">
                                            <!-- Modal content-->
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Ubah Data Pelanggan</h4>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>
                                                <div class="modal-body">
                                                    <form role="form" action="proses-edit-pelanggan.php" method="POST">
                                                        <?php
                                                        $id = $data['no_pelanggan'];
                                                        $query_edit = mysqli_query($koneksi, "SELECT * FROM pelanggan WHERE no_pelanggan='$id'");
                                                        while ($row = mysqli_fetch_array($query_edit)) {
                                                        ?>
                                                            <input type="hidden" name="no_pelanggan" value="<?= $row['no_pelanggan'] ?>">
                                                            <div class="form-group">
                                                                <label>No pelanggan </label>
                                                                <input type="number" name="no_pelanggan" class="form-control" value="<?= $row['no_pelanggan'] ?>" disabled>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Nama pelanggan</label>
                                                                <input type="text" name="nama" class="form-control" value="<?= $row['nama'] ?>">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Alamat</label>
                                                                <input type="text" name="alamat" class="form-control" value="<?php echo $row['alamat']; ?>">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Kontak</label>
                                                                <input type="text" name="no_hp" class="form-control" value="<?php echo $row['no_hp']; ?>">
                                                            </div>

                                                            <div class="modal-footer">
                                                                <button type="submit" class="btn btn-success">Ubah</button>
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
                                                    <h4 class="modal-title">Tambah pelanggan</h4>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>
                                                <!-- body modal -->
                                                <form action="tambah-pelanggan.php" method="get">
                                                    <div class="modal-body">
                                                        No pelanggan :
                                                        <input type="number" class="form-control" name="no_pelanggan">
                                                        Nama pelanggan :
                                                        <input type="text" class="form-control" name="nama">
                                                        Alamat :
                                                        <input type="text" class="form-control" name="alamat">
                                                        Kontak :
                                                        <input type="text" class="form-control" name="no_hp">
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

</body>

</html>
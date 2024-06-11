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
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body id="page-top">
    <?php require 'sidebar.php'; ?>

    <!-- Main Content -->
    <div id="content">
        <?php require 'navbar.php'; ?>

        <!-- Begin Page Content -->
        <div class="container-fluid">
            <button type="button" class="btn btn-success" style="margin:5px" data-toggle="modal" data-target="#myModalTambah"><i class="fa fa-plus"> Tambah Merek</i></button><br>

            <div class="modal fade" id="myModalTambah" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Tambah Daftar Merek</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <form role="form" action="tambah-merek.php" method="POST">

                                <div class="form-group">
                                    <label>ID Merek</label>
                                    <input type="text" name="id_merek" class="form-control" placeholder="Masukan ID">
                                </div>
                                <div class="form-group">
                                    <label>Nama Merek</label>
                                    <input type="text" name="merek" class="form-control" placeholder="Masukan Nama">
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

            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Daftar Merek</h6>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th width="10%">No</th>
                                    <th width="80%">Merek</th>
                                    <th width="10%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = mysqli_query($koneksi, "SELECT * FROM merek");
                                while ($data = mysqli_fetch_assoc($query)) {
                                ?>
                                    <tr>
                                        <td><?= isset($data['id_merek']) ? htmlspecialchars($data['id_merek']) : ''; ?></td>
                                        <td><?= isset($data['merek']) ? htmlspecialchars($data['merek']) : ''; ?></td>
                                        <td>
                                            <!-- Button for modal -->
                                            <a href="#" type="button" class="fa fa-edit btn btn-primary btn-md" data-toggle="modal" data-target="#myModal<?= isset($data['id_merek']) ? htmlspecialchars($data['id_merek']) : ''; ?>"> Edit</a>
                                        </td>
                                    </tr>
                                    <!-- Modal Edit -->
                                    <div class="modal fade" id="myModal<?= isset($data['id_merek']) ? htmlspecialchars($data['id_merek']) : ''; ?>" role="dialog">
                                        <div class="modal-dialog">

                                            <!-- Modal content-->
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Ubah Data Merek</h4>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>
                                                <div class="modal-body">
                                                    <form role="form" action="proses-edit-merek.php" method="post">
                                                        <?php
                                                        $id = isset($data['id_merek']) ? $data['id_merek'] : '';
                                                        $query_edit = mysqli_query($koneksi, "SELECT * FROM merek WHERE id_merek='$id'");
                                                        while ($row = mysqli_fetch_array($query_edit)) {
                                                        ?>
                                                            <input type="hidden" name="id_merek" value="<?= htmlspecialchars($row['id_merek']); ?>">

                                                            <div class="form-group">
                                                                <label>Merek</label>
                                                                <input type="text" name="merek" class="form-control" value="<?= htmlspecialchars($row['merek']); ?>">
                                                            </div>

                                                            <div class="modal-footer">
                                                                <button type="submit" class="btn btn-success">Ubah</button>
                                                                <a href="hapus-merek.php?id_merek=<?= htmlspecialchars($row['id_merek']); ?>" onclick="return confirm('Anda Yakin Ingin Menghapus?')" class="btn btn-danger">Hapus</a>
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
        <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->

    <?php require 'footer.php'; ?>

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
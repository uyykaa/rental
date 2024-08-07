<?php
session_start();
require 'koneksi.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Meta, title, dan CSS -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Laporan Penerimaan Kas</title>

    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Css khusus untuk mencetak -->
    <style type="text/css" media="print">
        /* Sembunyikan elemen yang tidak ingin dicetak */
        body * {
            visibility: hidden;
        }

        /* Tampilkan elemen yang ingin dicetak */
        #content,
        #content * {
            visibility: visible;
        }

        /* Atur tampilan untuk mencetak */
        #content {
            position: absolute;
            left: 0;
            top: 0;
        }
    </style>
</head>

<body id="page-top">
    <!-- Main Content -->
    <div id="content">
        <?php
        $role = $_SESSION['role_id'];
        $role == '2' ? require('sidebar-pemilik.php') : require('sidebar.php');
        require 'navbar.php';
        ?>

        <!-- Tombol Cetak -->
        <div class="container">
            <div class="card shadow mb-3">
                <div class="card-header py-3 text-center">
                    <h4 class="m-0 font-weight-bold text-primary"><img src="img/logo.jpg" height="50px auto"> GC PERSADA TRANSPORT</h4>
                    <h5>Laporan Penerimaan Kas</h5>
                </div>

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="tanggal_awal">Tanggal Awal :</label>
                                <input type="date" class="form-control" id="tanggal_awal" name="tanggal_awal" value="<?php echo isset($_GET['tanggal_awal']) ? $_GET['tanggal_awal'] : ''; ?>">
                            </div>
                            <div class="form-group">
                                <label for="tanggal_akhir">Tanggal Akhir :</label>
                                <input type="date" class="form-control" id="tanggal_akhir" name="tanggal_akhir" value="<?php echo isset($_GET['tanggal_akhir']) ? $_GET['tanggal_akhir'] : ''; ?>">
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary" style="margin:5px" onclick="applyFilter()">Filter</button>
                    <button type="button" class="btn btn-success" style="margin:5px" onclick="window.print()"><i class="fa fa-print"></i> Cetak</button><br>
                    <script>
                        function applyFilter() {
                            var tanggal_awal = document.getElementById('tanggal_awal').value;
                            var tanggal_akhir = document.getElementById('tanggal_akhir').value;
                            var url = 'laporan-penerimaan-kas.php';
                            url += '?tanggal_awal=' + tanggal_awal + '&tanggal_akhir=' + tanggal_akhir;
                            window.location.href = url;
                        }
                    </script>

                    <!-- Tabel Penerimaan Kas -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Kode</th>
                                        <th>Nama Akun</th>
                                        <th>Jumlah Penerimaan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $totalPendapatan = 0;
                                    $totalNominal = 0;
                                    $tanggal_awal = isset($_GET['tanggal_awal']) ? $_GET['tanggal_awal'] : date('Y-m-d');
                                    $tanggal_akhir = isset($_GET['tanggal_akhir']) ? $_GET['tanggal_akhir'] : date('Y-m-d');

                                    $queryPendapatan = mysqli_query($koneksi, "SELECT * FROM pendapatan_sewa WHERE tgl_pendapatan BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
                                    while ($data = mysqli_fetch_assoc($queryPendapatan)) :
                                        $jumlah_penerimaan = $data['jumlah_pendapatan'];
                                        $totalPendapatan += $jumlah_penerimaan;
                                    ?>
                                        <tr>
                                            <td><?= $data['tgl_pendapatan'] ?></td>
                                            <td><?= $data['id_pendapatan'] ?></td>
                                            <td><?= $data['nama_pendapatan'] ?></td>
                                            <td><?= number_format($data['jumlah_pendapatan'], 2, ',', '.'); ?></td>
                                        </tr>
                                    <?php endwhile; ?>

                                    <?php
                                    $queryModal = mysqli_query($koneksi, "SELECT * FROM modal WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
                                    while ($data = mysqli_fetch_assoc($queryModal)) :
                                        $nominal = $data['nominal'];
                                        $totalNominal += $nominal;
                                    ?>
                                        <tr>
                                            <td><?= $data['tanggal'] ?></td>
                                            <td><?= $data['id_modal'] ?></td>
                                            <td>Modal</td>
                                            <td><?= number_format($data['nominal'], 2, ',', '.'); ?></td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="3" style="text-align: right;">Total Pendapatan</th>
                                        <th>Rp. <?= number_format($totalPendapatan + $totalNominal, 2, ',', '.'); ?></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bootstrap core JavaScript -->
        <script src="vendor/jquery/jquery.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- Core Plugin JavaScript -->
        <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
        <!-- Custom scripts for all pages -->
        <script src="js/sb-admin-2.min.js"></script>
        <!-- Page level custom scripts -->
        <script src="js/demo/datatables-demo.js"></script>
</body>

</html>
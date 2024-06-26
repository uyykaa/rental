<?php
session_start();
require 'koneksi.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Meta, title, and CSS -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Buku Besar Kas</title>

    <!-- Custom fonts and CSS for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <style type="text/css" media="print">
        /* Hide elements not to be printed */
        body * {
            visibility: hidden;
        }

        /* Show print area */
        #content,
        #content * {
            visibility: visible;
        }

        /* Set position for print area */
        #content {
            position: absolute;
            left: 0;
            top: 0;
        }
    </style>
</head>

<body id="page-top">
    <!-- Include navbar -->
    <?php
    $role = $_SESSION['role_id'];
    $role == '2' ? require('sidebar-pemilik.php') : require('sidebar.php');
    require 'navbar.php'; ?>

    <!-- Main Content -->
    <div id="content">
        <!-- Print Button -->
        <div class="container">
            <div class="card shadow mb-4">
                <div class="card-header py-3 text-center">
                    <h4 class="m-0 font-weight-bold text-primary"><img src="img/logo.jpg" height="50px auto"> GC PERSADA TRANSPORT</h4>
                    <h5> Laporan Buku Besar Kas </h5>
                </div>

                <!-- Page Content -->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="tanggal_awal">Tanggal Awal:</label>
                                <input type="date" class="form-control" id="tanggal_awal" name="tanggal_awal" value="<?php echo isset($_GET['tanggal_awal']) ? $_GET['tanggal_awal'] : ''; ?>">
                            </div>
                            <div class="form-group">
                                <label for="tanggal_akhir">Tanggal Akhir:</label>
                                <input type="date" class="form-control" id="tanggal_akhir" name="tanggal_akhir" value="<?php echo isset($_GET['tanggal_akhir']) ? $_GET['tanggal_akhir'] : ''; ?>">
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary" onclick="applyFilter()">Filter</button>
                    <button type="button" class="btn btn-success" style="margin:5px" onclick="window.print()"><i class="fa fa-print"></i> Cetak
                    </button>
                    <script>
                        function applyFilter() {
                            var tanggal_awal = document.getElementById('tanggal_awal').value;
                            var tanggal_akhir = document.getElementById('tanggal_akhir').value;
                            var url = 'buku-besar.php';
                            url += '?tanggal_awal=' + tanggal_awal + '&tanggal_akhir=' + tanggal_akhir;
                            window.location.href = url;
                        }
                    </script>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Kode Transaksi</th>
                                        <th>Nama Akun</th>
                                        <th>Debet</th>
                                        <th>Kredit</th>
                                        <th>Saldo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $tanggal_awal = isset($_GET['tanggal_awal']) ? $_GET['tanggal_awal'] : date('Y-m-d');
                                    $tanggal_akhir = isset($_GET['tanggal_akhir']) ? $_GET['tanggal_akhir'] : date('Y-m-d');

                                    // Query untuk mengambil data pendapatan_sewa berdasarkan periode tanggal yang dipilih
                                    $queryPendapatan = mysqli_query($koneksi, "SELECT * FROM pendapatan_sewa WHERE tgl_pendapatan BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");

                                    // Query untuk mengambil data operasional berdasarkan periode tanggal yang dipilih
                                    $queryOperasional = mysqli_query($koneksi, "SELECT * FROM operasional WHERE tanggal_operasional BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");

                                    $totalPendapatan = 0;
                                    $totalOperasional = 0;
                                    $var_saldo = 0;

                                    // Menampilkan data pendapatan
                                    while ($data = $queryPendapatan->fetch_assoc()) : ?>
                                        <tr>
                                            <td align="center"><?= date('Y-m-d', strtotime($data['tgl_pendapatan'])); ?></td>
                                            <td align="center"><?= $data['id_pendapatan']; ?></td>
                                            <td><?= $data['nama_pendapatan']; ?></td>
                                            <td>Rp. <?= number_format($data['jumlah_pendapatan'], 2, ',', '.'); ?></td>
                                            <td></td>
                                            <td>Rp. <?= number_format($var_saldo += $data['jumlah_pendapatan'], 2, ',', '.'); ?></td>
                                        </tr>
                                    <?php
                                        $totalPendapatan += $data['jumlah_pendapatan'];
                                    endwhile;

                                    // Menampilkan data operasional
                                    while ($data = $queryOperasional->fetch_assoc()) : ?>
                                        <tr>
                                            <td align="center"><?= date('Y-m-d', strtotime($data['tanggal_operasional'])); ?></td>
                                            <td align="center"><?= $data['id_operasional']; ?></td>
                                            <td><?= $data['nama_operasional']; ?></td>
                                            <td></td>
                                            <td>Rp. <?= number_format($data['total_operasional'], 2, ',', '.'); ?></td>
                                            <td>Rp. <?= number_format($var_saldo -= $data['total_operasional'], 2, ',', '.'); ?></td>
                                        </tr>
                                    <?php
                                        $totalOperasional += $data['total_operasional'];
                                    endwhile;
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="3">
                                            <center>Total</center>
                                        </th>
                                        <td>Rp. <?= number_format($totalPendapatan, 2, ',', '.'); ?></td>
                                        <td>Rp. <?= number_format($totalOperasional, 2, ',', '.'); ?></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <th colspan="5">
                                            <center>Saldo Akhir</center>
                                        </th>
                                        <td>Rp. <?= number_format($var_saldo, 2, ',', '.'); ?></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- End of Page Content -->
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
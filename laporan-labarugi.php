<?php
session_start();
require 'koneksi.php';

$tanggal_awal = isset($_GET['tanggal_awal']) ? $_GET['tanggal_awal'] : date('Y-m-01');
$tanggal_akhir = isset($_GET['tanggal_akhir']) ? $_GET['tanggal_akhir'] : date('Y-m-t');

// Query to get pendapatan_sewa for the selected date range
$queryPendapatan_sewa = mysqli_query($koneksi, "SELECT * FROM pendapatan_sewa WHERE tgl_pendapatan BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
$totalPendapatan = 0;

// Query to get operasional for the selected date range
$queryOperasional = mysqli_query($koneksi, "SELECT * FROM operasional WHERE tanggal_operasional BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
$totalOperasional = 0;

// Calculate total pendapatan
while ($data = mysqli_fetch_assoc($queryPendapatan_sewa)) {
    $jumlah = isset($data['jumlah_pendapatan']) ? $data['jumlah_pendapatan'] : 0;
    $totalPendapatan += $jumlah;
}

// Calculate total operasional
while ($data = mysqli_fetch_assoc($queryOperasional)) {
    $harga = isset($data['harga']) ? $data['harga'] : 0;
    $kuantitas = isset($data['kuantitas']) ? $data['kuantitas'] : 0;
    $jumlah = $harga * $kuantitas;
    $totalOperasional += $jumlah;
}

// Calculate Laba Rugi
$LabaRugi = $totalPendapatan - $totalOperasional;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Laporan Laba Rugi</title>

    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <!-- CSS for printing -->
    <style type="text/css" media="print">
        body * {
            visibility: hidden;
        }

        #content,
        #content * {
            visibility: visible;
        }

        #content {
            position: absolute;
            left: 0;
            top: 0;
        }

        #select {
            width: 50px;
        }
    </style>
</head>

<body id="page-top">
    <div id="content">
        <?php
        $role = $_SESSION['role_id'];
        $role == '2' ? require('sidebar-pemilik.php') : require('sidebar.php');
        require 'navbar.php'; ?>

        <!-- Begin Page Content -->
        <div class="container">
            <div class="card shadow mb-4">
                <div class="card-header py-3 text-center">
                    <h4 class="m-0 font-weight-bold text-primary"><img src="img/logo.jpg" height="50px auto"> GC PERSADA TRANSPORT</h4>
                    <h5>Laporan Laba Rugi</h5>
                </div>

                <div class="container">
                    <div class="row">
                        <div class="col-lg-4">
                            <label for="tanggal_awal">Tanggal Awal:</label>
                            <input type="date" id="tanggal_awal" class="form-control" onchange="updateURL()">
                        </div>
                        <div class="col-lg-4">
                            <label for="tanggal_akhir">Tanggal Akhir:</label>
                            <input type="date" id="tanggal_akhir" class="form-control" onchange="updateURL()">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-lg-4">
                            <button type="button" class="btn btn-primary" onclick="updateURL()"><i class="fa fa-filter"></i> Filter</button>
                            <button type="button" class="btn btn-success" onclick="window.print()"><i class="fa fa-print"></i> Cetak</button>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-lg-6">
                            <label>Total Pendapatan</label>
                            <div class="amount">Rp. <?= number_format($totalPendapatan, 2, ',', '.'); ?></div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-lg-6">
                            <label>Total Operasional</label>
                            <div class="amount">Rp. <?= number_format($totalOperasional, 2, ',', '.'); ?></div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-lg-6">
                            <label>Laba / Rugi</label>
                            <div class="amount <?= $LabaRugi >= 0 ? 'laba' : 'rugi'; ?>">
                                Rp. <?= number_format($LabaRugi, 2, ',', '.'); ?>
                                <?= $LabaRugi >= 0 ? '(Laba)' : '(Rugi)'; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function updateURL() {
            var tanggal_awal = document.getElementById('tanggal_awal').value;
            var tanggal_akhir = document.getElementById('tanggal_akhir').value;
            if (tanggal_awal && tanggal_akhir) {
                window.location.href = 'laporan-labarugi.php?tanggal_awal=' + tanggal_awal + '&tanggal_akhir=' + tanggal_akhir;
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('tanggal_awal').value = '<?= isset($_GET['tanggal_awal']) ? $_GET['tanggal_awal'] : ''; ?>';
            document.getElementById('tanggal_akhir').value = '<?= isset($_GET['tanggal_akhir']) ? $_GET['tanggal_akhir'] : ''; ?>';
        });
    </script>

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

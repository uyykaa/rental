<?php
session_start();
require 'koneksi.php';

$selectedMonth = isset($_GET['bulan']) ? $_GET['bulan'] : date('m');

// Query to get pendapatan_sewa for the selected month
$queryPendapatan_sewa = mysqli_query($koneksi, "SELECT * FROM pendapatan_sewa WHERE MONTH(tgl_pendapatan) = '$selectedMonth'");
$totalPendapatan = 0;

// Query to get operasional for the selected month
$queryOperasional = mysqli_query($koneksi, "SELECT * FROM operasional WHERE MONTH(tanggal_operasional) = '$selectedMonth'");
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
        <?php require 'navbar.php'; ?>

        <!-- Print Button -->


        <div class="container">
            <div class="card shadow mb-4">
                <div class="card-header py-3 text-center">
                    <h4 class="m-0 font-weight-bold text-primary"><img src="img/logo.jpg" height="50px auto"> GC PERSADA TRANSPORT</h4>
                    <h5>Laporan Laba Rugi</h5>
                </div>
                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <div class="form-group">
                        <label for="bulan">Filter Bulan :</label>
                        <select class="form-control" id="bulan" name="bulan">
                            <option value="01">Januari</option>
                            <option value="02">Februari</option>
                            <option value="03">Maret</option>
                            <option value="04">April</option>
                            <option value="05">Mei</option>
                            <option value="06">Juni</option>
                            <option value="07">Juli</option>
                            <option value="08">Agustus</option>
                            <option value="09">September</option>
                            <option value="10">Oktober</option>
                            <option value="11">November</option>
                            <option value="12">Desember</option>
                        </select>
                    </div>
                    <div class="col-lg-2">
                        <button type="button" class="btn btn-success" style="margin:5px" onclick="window.print()">
                            <i class="fa fa-plus"> Cetak</i>
                        </button><br>
                    </div>
                    <script>
                        document.getElementById('bulan').addEventListener('change', function() {
                            var selectedMonth = this.value;
                            window.location.href = 'laporan-labarugi.php?bulan=' + selectedMonth;
                        });
                        document.getElementById('bulan').value = '<?php echo $selectedMonth; ?>';
                    </script>
                    <div class="container">
                        <div class="row">
                            <table class="label">Total Pendapatan</table>
                        </div>
                        <div class="amount">Rp. <?= number_format($totalPendapatan, 2, ',', '.'); ?></div>
                        <div class="row">
                            <table class="label">Total Operasional</table>
                        </div>
                        <div class="amount">Rp. <?= number_format($totalOperasional, 2, ',', '.'); ?></div>
                        <div class="row">
                            <table class="label">Laba / Rugi</table>
                        </div>
                        <div class="amount <?= $LabaRugi >= 0 ? 'laba' : 'rugi'; ?>">
                            Rp. <?= number_format($LabaRugi, 2, ',', '.'); ?>
                            <?= $LabaRugi >= 0 ? '(Laba)' : '(Rugi)'; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
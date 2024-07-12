<?php
session_start();
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
    <title>LAPORAN PERUBAHAN MODAL</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
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
    </style>
    <style>
        .btn-print {
            margin-top: 10px;
        }

        .table {
            margin-top: 20px;
        }

        .form-group {
            display: flex;
            align-items: center;
        }

        .form-group label {
            margin-right: 10px;
        }

        .form-group input[type="month"] {
            flex: 1;
            min-width: 50px;
        }
    </style>
</head>

<body id="page-top">
    <div id="content">
        <?php
        $role = $_SESSION['role_id'];
        $role == '2' ? require('sidebar-pemilik.php') : require('sidebar.php');
        require 'navbar.php'; ?>
        <div class="container">
            <div class="card shadow mb-4">
                <div class="card-header py-3 text-center">
                    <h4 class="m-0 font-weight-bold text-primary">GC PERSADA TRANSPORT</h4>
                    <h5>Laporan Perubahan Modal</h5>
                    <h6>Per <?php echo isset($_GET['bulan']) ? date('F Y', strtotime($_GET['bulan'])) : date('F Y'); ?></h6>
                </div>
                <div class="container-fluid">
                    <form method="GET" action="laporan-perubahan-modal.php">
                        <div class="form-group">
                            <label for="tanggal_awal">Tanggal Awal:</label>
                            <input type="date" class="form-control" id="tanggal_awal" name="tanggal_awal" value="<?php echo isset($_GET['tanggal_awal']) ? $_GET['tanggal_awal'] : date('Y-m-01'); ?>">
                        </div>
                        <div class="form-group">
                            <label for="tanggal_akhir">Tanggal Akhir:</label>
                            <input type="date" class="form-control" id="tanggal_akhir" name="tanggal_akhir" value="<?php echo isset($_GET['tanggal_akhir']) ? $_GET['tanggal_akhir'] : date('Y-m-d'); ?>">
                        </div>
                        <button type="submit" class="btn btn-primary">Filter</button>
                        <button type="button" class="btn btn-success btn-print" onclick="window.print()"><i class="fa fa-print"></i> Cetak</button>
                    </form>
                    
                    <!-- Laporan Perubahan Modal Section -->
                    <div class="container-fluid">
                        <?php
                        // Set the $bulan variable
                        $bulan = isset($_GET['bulan']) ? $_GET['bulan'] : date('Y-m');

                        // Default values for Laporan Perubahan Modal
                        $modal_awal = 0;
                        $laba = 0;
                        $prive = 0;

                        // Fetch Modal Awal from modal_awal table or similar
                        $query_modal_awal = "SELECT modal_awal FROM modal_awal LIMIT 1";
                        $result_modal_awal = mysqli_query($koneksi, $query_modal_awal);
                        if ($result_modal_awal && $row_modal_awal = mysqli_fetch_assoc($result_modal_awal)) {
                            $modal_awal = $row_modal_awal['modal_awal'];
                        }

                        // Fetch Laba from laporan laba/rugi
                        $query_laba = "SELECT SUM(total_pendapatan) - SUM(total_biaya) as total_laba FROM laporan_laba_rugi WHERE DATE_FORMAT(tanggal, '%Y-%m') = '$bulan'";
                        $result_laba = mysqli_query($koneksi, $query_laba);
                        if ($result_laba && $row_laba = mysqli_fetch_assoc($result_laba)) {
                            $laba = $row_laba['total_laba'];
                        }

                        // Fetch Prive from prive table or similar
                        $query_prive = "SELECT SUM(prive) as total_prive FROM prive WHERE DATE_FORMAT(tanggal, '%Y-%m') = '$bulan'";
                        $result_prive = mysqli_query($koneksi, $query_prive);
                        if ($result_prive && $row_prive = mysqli_fetch_assoc($result_prive)) {
                            $prive = $row_prive['total_prive'];
                        }

                        // Calculate Modal Akhir
                        $modal_akhir = $modal_awal + $laba - $prive;
                        ?>
                        <table class="table table-bordered report-table">
                            <tr>
                                <td>Modal Awal</td>
                                <td class="amount">Rp. <?php echo number_format($modal_awal, 2); ?></td>
                            </tr>
                            <tr>
                                <td>Laba </td>
                                <td class="amount">Rp. <?php echo number_format($laba, 2); ?></td>
                            </tr>
                            <tr>
                                <td>Prive</td>
                                <td class="amount">(Rp. <?php echo number_format($prive, 2); ?>)</td>
                            </tr>
                            <tr>
                                <td><strong>Modal Akhir</strong></td>
                                <td class="amount"><strong>Rp. <?php echo number_format($modal_akhir, 2); ?></strong></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="js/sb-admin-2.min.js"></script>
<script src="vendor/datatables/jquery.dataTables.min.js"></script>
<script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script src="js/demo/datatables-demo.js"></script>
</body>

</html>

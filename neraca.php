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
    <title>Neraca</title>
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
                    <h5>Neraca</h5>
                    <h6>Per <?php echo isset($_GET['bulan']) ? date('F Y', strtotime($_GET['bulan'])) : date('F Y'); ?></h6>
                </div>
                <div class="container-fluid">
                    <form method="GET" action="neraca.php">
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
                    <div class="table-responsive">
                        <?php
                        // Define tanggal_awal and tanggal_akhir
                        $tanggal_awal = isset($_GET['tanggal_awal']) ? $_GET['tanggal_awal'] : date('Y-m-01');
                        $tanggal_akhir = isset($_GET['tanggal_akhir']) ? $_GET['tanggal_akhir'] : date('Y-m-d');

                        // Default values
                        $kas = $utang = $kendaraan = $modal_awal = $laba = $modal_gc_persada = 0;

                        // Get the month value
                        $bulan = isset($_GET['bulan']) ? $_GET['bulan'] : date('Y-m');

                        // Fetch kas from pendapatan_sewa
                        $query_kas = "SELECT SUM(jumlah_pendapatan) as total_kas FROM pendapatan_sewa WHERE DATE_FORMAT(tgl_pendapatan, '%Y-%m') = '$bulan'";
                        $result_kas = mysqli_query($koneksi, $query_kas);
                        if ($result_kas && $row_kas = mysqli_fetch_assoc($result_kas)) {
                            $kas = $row_kas['total_kas'];
                        }

                        // Fetch utang from operasional with id_akun 2-01
                        $query_utang = "SELECT SUM(total_operasional) as total_utang FROM operasional WHERE id_akun = '2-01' AND DATE_FORMAT(tanggal_operasional, '%Y-%m') = '$bulan'";
                        $result_utang = mysqli_query($koneksi, $query_utang);
                        if ($result_utang && $row_utang = mysqli_fetch_assoc($result_utang)) {
                            $utang = $row_utang['total_utang'];
                        }

                        // Fetch kendaraan value from modal
                        $query_kendaraan = "SELECT SUM(nominal) as total_kendaraan FROM modal WHERE nama_akun = 'Kendaraan' AND tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'";
                        $result_kendaraan = mysqli_query($koneksi, $query_kendaraan);
                        if ($result_kendaraan && $row_kendaraan = mysqli_fetch_assoc($result_kendaraan)) {
                            $kendaraan = $row_kendaraan['total_kendaraan'];
                        }

                        // Fetch modal_awal
                        $query_modal_awal = "SELECT SUM(nominal) as total_modal_awal FROM modal WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'";
                        $result_modal_awal = mysqli_query($koneksi, $query_modal_awal);
                        if ($result_modal_awal && $row_modal_awal = mysqli_fetch_assoc($result_modal_awal)) {
                            $modal_awal = $row_modal_awal['total_modal_awal'];
                        }

                        // Fetch laba
                        $query_laba = "SELECT SUM(total_laba) as total_laba FROM laba_rugi WHERE DATE_FORMAT(tanggal_laba, '%Y-%m') = '$bulan'";
                        $result_laba = mysqli_query($koneksi, $query_laba);
                        if ($result_laba && $row_laba = mysqli_fetch_assoc($result_laba)) {
                            $laba = $row_laba['total_laba'];
                        }

                        // Calculate Laba Rugi
                        // Assuming $total_pendapatan and $total_pengeluaran are calculated elsewhere or need to be fetched
                        $total_pendapatan = $kas; // Example
                        $total_pengeluaran = $utang; // Example
                        $laba_rugi = $total_pendapatan - $total_pengeluaran;

                        // Calculate Modal GC Persada
                        $modal_gc_persada = $modal_awal + $laba_rugi;

                        // Calculate total aktiva and passiva
                        $jumlah_aktiva = $kas + $kendaraan; // Sum up both Aktiva Lancar and Aktiva Tetap
                        $jumlah_passiva = $utang + $modal_gc_persada;
                        ?>
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>AKTIVA</th>
                                    <th>PASSIVA</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <table class="table table-borderless">
                                            <tr>
                                                <th>Aktiva Lancar</th>
                                            </tr>
                                            <tr>
                                                <td>Kas</td>
                                                <td><?php echo number_format($kas, 2); ?></td>
                                            </tr>
                                            <tr>
                                                <th>Aktiva Tetap</th>
                                            </tr>
                                            <tr>
                                                <td>Kendaraan</td>
                                                <td><?php echo number_format($kendaraan, 2); ?></td>
                                            </tr>
                                            <tr>
                                                <th>Jumlah Aktiva</th>
                                                <th><?php echo number_format($jumlah_aktiva, 2); ?></th>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table class="table table-borderless">
                                            <tr>
                                                <th>Utang</th>
                                            </tr>
                                            <tr>
                                                <td>Utang</td>
                                                <td><?php echo number_format($utang, 2); ?></td>
                                            </tr>
                                            <tr>
                                                <th>Ekuitas</th>
                                            </tr>
                                            <tr>
                                                <td>Modal GC Persada</td>
                                                <td><?php echo number_format($modal_gc_persada, 2); ?></td>
                                            </tr>
                                            <tr>
                                                <th>Jumlah Passiva</th>
                                                <th><?php echo number_format($jumlah_passiva, 2); ?></th>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
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

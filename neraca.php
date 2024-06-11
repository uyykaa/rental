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
        #content, #content * {
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
    </style>
</head>
<body id="page-top">
<div id="content">
    <?php require 'navbar.php'; ?>
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
                        <label for="bulan">Bulan:</label>
                        <input type="month" class="form-control" id="bulan" name="bulan" value="<?php echo isset($_GET['bulan']) ? $_GET['bulan'] : date('Y-m'); ?>">
                    </div>
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <button type="button" class="btn btn-success btn-print" onclick="window.print()">
                        <i class="fa fa-print"> Cetak</i>
                    </button>
                </form>
                <div class="table-responsive">
                    <?php
                    // Default values
                    $kas = $piutang_usaha = $perlengkapan = $peralatan = $akm_peny_peralatan = $utang = $modal_gc_persada = 0;

                    // Example queries to fetch values from the database
                    // Adjust these queries according to your actual database structure
                    $bulan = isset($_GET['bulan']) ? $_GET['bulan'] : date('Y-m');
                    
                    $query = "SELECT * FROM akun WHERE bulan = '$bulan'";
                    $result = mysqli_query($koneksi, $query);

                    while ($row = mysqli_fetch_assoc($result)) {
                        $kas = $row['kas'];
                        $piutang_usaha = $row['piutang_usaha'];
                        $perlengkapan = $row['perlengkapan'];
                        $peralatan = $row['peralatan'];
                        $akm_peny_peralatan = $row['akm_peny_peralatan'];
                        $utang = $row['utang'];
                        $modal_gc_persada = $row['modal_gc_persada'];
                    }

                    $jumlah_aktiva = $kas + $piutang_usaha + $perlengkapan + $peralatan - $akm_peny_peralatan;
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
                                            <td>Kas</td>
                                            <td><?php echo number_format($kas, 2); ?></td>
                                        </tr>
                                        <tr>
                                            <td>Piutang Usaha</td>
                                            <td><?php echo number_format($piutang_usaha, 2); ?></td>
                                        </tr>
                                        <tr>
                                            <td>Perlengkapan</td>
                                            <td><?php echo number_format($perlengkapan, 2); ?></td>
                                        </tr>
                                        <tr>
                                            <td>Peralatan</td>
                                            <td><?php echo number_format($peralatan, 2); ?></td>
                                        </tr>
                                        <tr>
                                            <td>Akm. Peny. Peralatan</td>
                                            <td><?php echo number_format($akm_peny_peralatan, 2); ?></td>
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
                                            <td>Utang</td>
                                            <td><?php echo number_format($utang, 2); ?></td>
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
                            <?php if ($jumlah_aktiva !== $jumlah_passiva) : ?>
                            <tr>
                                <td colspan="2" class="text-danger text-center">
                                    <strong>Jumlah Aktiva tidak sama dengan Jumlah Passiva!</strong>
                                </td>
                            </tr>
                            <?php endif; ?>
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

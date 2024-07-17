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
    <title>Neraca Saldo</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
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
    <div class="container">
        <div class="card shadow mb-4">
            <div class="card-header py-3 text-center">
                <h4 class="m-0 font-weight-bold text-primary">GC PERSADA TRANSPORT</h4>
                <h5>Neraca Saldo</h5>
                <h6>Per <?php echo isset($_GET['tanggal']) ? date('d/m/Y', strtotime($_GET['tanggal'])) : date('d/m/Y'); ?></h6>
            </div>
            <div class="container-fluid">
                <form method="GET" action="neraca_saldo.php">
                    <div class="form-group">
                        <label for="tanggal">Tanggal:</label>
                        <input type="date" class="form-control" id="tanggal" name="tanggal" value="<?php echo isset($_GET['tanggal']) ? $_GET['tanggal'] : date('Y-m-d'); ?>">
                    </div>
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <button type="button" class="btn btn-success btn-print" onclick="window.print()">
                        <i class="fa fa-print"> Cetak</i>
                    </button>
                </form>
                <div class="table-responsive">
                    <?php
                    // Default values
                    $tanggal = isset($_GET['tanggal']) ? $_GET['tanggal'] : date('Y-m-d');
                    
                    $query = "SELECT kode_akun, nama_akun, debet, kredit FROM akun WHERE tanggal = '$tanggal'";
                    $result = mysqli_query($koneksi, $query);

                    $total_debet = 0;
                    $total_kredit = 0;
                    ?>
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Kode Akun</th>
                                <th>Nama Akun</th>
                                <th>Debet</th>
                                <th>Kredit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                            <tr>
                                <td><?php echo $row['kode_akun']; ?></td>
                                <td><?php echo $row['nama_akun']; ?></td>
                                <td><?php echo number_format($row['debet'], 2); ?></td>
                                <td><?php echo number_format($row['kredit'], 2); ?></td>
                            </tr>
                            <?php
                                $total_debet += $row['debet'];
                                $total_kredit += $row['kredit'];
                            ?>
                            <?php endwhile; ?>
                            <tr>
                                <th colspan="2">Total</th>
                                <th><?php echo number_format($total_debet, 2); ?></th>
                                <th><?php echo number_format($total_kredit, 2); ?></th>
                            </tr>
                            <?php if ($total_debet !== $total_kredit) : ?>
                            <tr>
                                <td colspan="4" class="text-danger text-center">
                                    <strong>Debet dan Kredit tidak seimbang!</strong>
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
</body>
</html>

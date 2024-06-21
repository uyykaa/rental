<?php
session_start();
require 'koneksi.php';

// Mengambil nilai tanggal dari parameter GET atau menggunakan nilai default (tanggal hari ini)
$tanggal_awal = isset($_GET['tanggal_awal']) ? $_GET['tanggal_awal'] : date('Y-m-d');
$tanggal_akhir = isset($_GET['tanggal_akhir']) ? $_GET['tanggal_akhir'] : date('Y-m-d');

// Query untuk mengambil data pendapatan sewa
$queryPendapatanSewa = mysqli_query($koneksi, "SELECT * FROM pendapatan_sewa WHERE tgl_pendapatan BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");

// Query untuk mengambil data operasional
$queryOperasional = mysqli_query($koneksi, "SELECT * FROM operasional WHERE tanggal_operasional BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");

// Variabel total untuk pendapatan dan operasional
$totalPendapatan = 0;
$totalOperasional = 0;

// Variabel total debit dan kredit
$totalDebit = 0;
$totalKredit = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Jurnal Umum</title>
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
        .filter-container {
            display: flex;
            align-items: flex-end;
            gap: 10px;
        }
        .filter-container div {
            flex: 1;
        }
        .btn-print {
            margin-top: 10px;
        }
        .alert {
            margin-top: 20px;
        }
    </style>
</head>
<body id="page-top">
<?php require 'navbar.php'; ?>
<div id="content">
    <div class="container">
        <div class="card shadow mb-4">
            <div class="card-header py-3 text-center">
                <h4 class="m-0 font-weight-bold text-primary">GC PERSADA TRANSPORT</h4>
                <h5>Jurnal Umum</h5>
            </div>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group filter-container">
                            <div>
                                <label for="tanggal_awal">Tanggal Awal:</label>
                                <input type="date" class="form-control" id="tanggal_awal" name="tanggal_awal" value="<?php echo isset($_GET['tanggal_awal']) ? $_GET['tanggal_awal'] : ''; ?>">
                            </div>
                            <div>
                                <label for="tanggal_akhir">Tanggal Akhir:</label>
                                <input type="date" class="form-control" id="tanggal_akhir" name="tanggal_akhir" value="<?php echo isset($_GET['tanggal_akhir']) ? $_GET['tanggal_akhir'] : ''; ?>">
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary" onclick="applyFilter()">Filter</button>
                        <button type="button" class="btn btn-success btn-print" onclick="window.print()">
                            <i class="fa fa-print"> Cetak</i>
                        </button>
                    </div>
                </div>
                <script>
                    function applyFilter() {
                        var tanggal_awal = document.getElementById('tanggal_awal').value;
                        var tanggal_akhir = document.getElementById('tanggal_akhir').value;
                        var url = 'jurnal-umum.php';
                        url += '?tanggal_awal=' + tanggal_awal + '&tanggal_akhir=' + tanggal_akhir;
                        window.location.href = url;
                    }
                </script>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Kode transaksi</th>
                                <th>Keterangan</th>
                                <th>Debet</th>
                                <th>Kredit</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            // Loop untuk data pendapatan sewa
                            while ($data = mysqli_fetch_assoc($queryPendapatanSewa)) {
                                $jumlah = isset($data['jumlah_pendapatan']) ? $data['jumlah_pendapatan'] : 0;
                                $totalPendapatan += $jumlah;
                                $totalDebit += $jumlah;
                                ?>
                                <tr>
                                    <td><?= date('Y-m-d', strtotime($data['tgl_pendapatan'])); ?></td>
                                    <td><?= $data['id_pendapatan']; ?></td>
                                    <td>
                                        Kas<br>&nbsp;&nbsp; <?= $data['nama_pendapatan']; ?><br><?= $data['nama_pendapatan']; ?>
                                    </td>
                                    <td><?= "Rp." . number_format($jumlah); ?></td>
                                    <td></td>
                                </tr>
                                <?php
                            }
                            
                            // Loop untuk data operasional
                            while ($data = mysqli_fetch_assoc($queryOperasional)) {
                                $jumlah = isset($data['total_operasional']) ? $data['total_operasional'] : 0;
                                $totalOperasional += $jumlah;
                                $totalKredit += $jumlah;
                                ?>
                                <tr>
                                    <td><?= date('Y-m-d', strtotime($data['tanggal_operasional'])); ?></td>
                                    <td><?= $data['id_operasional']; ?></td>
                                    <td>
                                        <?= $data['nama_operasional']; ?><br>&nbsp;&nbsp; Kas<br><?= $data['nama_operasional']; ?>
                                    </td>
                                    <td></td>
                                    <td><?= "Rp." . number_format($jumlah); ?></td>
                                </tr>
                                <?php
                            }                        
                            ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th colspan="3"><center>Total</center></th>
                                <td><?= "Rp." . number_format($totalPendapatan); ?></td>
                                <td><?= "Rp." . number_format($totalOperasional); ?></td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                    <?php
                    // Peringatan jika total debit dan kredit tidak sama
                    if ($totalDebit !== $totalKredit) {
                        echo '<div class="alert alert-warning">Total debit dan kredit tidak sama!</div>';
                    }
                    ?>
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

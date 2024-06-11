<?php
session_start();
?>
<!-- laporan-buku-besar.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Masukkan meta, title dan CSS yang diperlukan -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Buku Besar Kas</title>

    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <style type="text/css" media="print">
        /* Sembunyikan elemen yang tidak ingin dicetak */
        body * {
            visibility: hidden;
        }
        /* Kecuali elemen yang ingin dicetak */   
        #content, #content * {
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
    <?php
    require 'koneksi.php';
    ?>

    <!-- Main Content -->
    <div id="content">
        <?php require 'navbar.php'; ?>

        <!-- Tombol Cetak -->
        <button type="button" class="btn btn-success" style="margin:5px" onclick="window.print()">
        <i class="fa fa-print"> Cetak</i></button></br>
        <div class="container">
            <div class="card shadow mb-4">
                <div class="card-header py-3 text-center">
                    <h4 class="m-0 font-weight-bold text-primary"> GC PERSADA TRANSPORT</h4>
                    <h5> Laporan Buku Besar Kas </h5>
                </div>

                <!-- Begin Page Content -->
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
                    <script>
                        function applyFilter() {
                            var tanggal_awal = document.getElementById('tanggal_awal').value;
                            var tanggal_akhir = document.getElementById('tanggal_akhir').value;
                            var url = 'laporan-buku-besar.php';
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
                                        <th>Id Transaksi</th>
                                        <th>Keterangan</th>
                                        <th>Debet</th>
                                        <th>Kredit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $tanggal_awal = isset($_GET['tanggal_awal']) ? $_GET['tanggal_awal'] : date('Y-m-d');
                                    $tanggal_akhir = isset($_GET['tanggal_akhir']) ? $_GET['tanggal_akhir'] : date('Y-m-d');

                                    // Query untuk mengambil data pendapatan dan operasional berdasarkan periode tanggal yang dipilih
                                    $queryPendapatan = mysqli_query($koneksi, "SELECT * FROM pendapatan WHERE tgl_pendapatan BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
                                    $queryOperasional = mysqli_query($koneksi, "SELECT * FROM operasional WHERE tanggal_operasional BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");

                                    $totalPendapatan = 0;
                                    $totalOperasional = 0;
                                    $no = 1;
                                    $var_saldo = 0;

                                    // Menampilkan data pendapatan
                                    while ($data = $queryPendapatan->fetch_assoc()) : ?>
                                        <tr>
                                            <td align="center"><?= date('Y-m-d', strtotime($data['tgl_pendapatan'])); ?></td>
                                            <td align="center"><?= $data['id_pendapatan']; ?></td>
                                            <td>
                                                Kas<br>
                                                &nbsp;&nbsp; <?= $data['nama_akun']; ?><br>
                                                <?= $data['keterangan']; ?>
                                            </td>
                                            <td>
                                                Rp. <?= number_format($data['jumlah'], 2, ',', '.'); ?>
                                            </td>
                                            <td>
                                            </td>
                                        </tr>
                                        <?php
                                        $var_saldo += $data['jumlah'];
                                        $totalPendapatan += $data['jumlah'];
                                    endwhile;

                                    // Menampilkan data operasional
                                    while ($data = $queryOperasional->fetch_assoc()) : ?>
                                        <tr>
                                            <td align="center"><?= date('Y-m-d', strtotime($data['tanggal_operasional`'])); ?></td>
                                            <td align="center"><?= $data['id_operasional']; ?></td>
                                            <td>
                                                <?= $data['nama_akun']; ?><br>
                                                &nbsp;&nbsp; Kas<br>
                                                <?= $data['keterangan']; ?>
                                            </td>
                                            <td>
                                            </td>
                                            <td>
                                                Rp. <?= number_format($data['jumlah'], 2, ',', '.'); ?>
                                            </td>
                                        </tr>
                                        <?php
                                        $var_saldo -= $data['jumlah'];
                                        $totalOperasional += $data['jumlah'];
                                    endwhile;
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="3"><center>Total</center></th>
                                        <td>Rp. <?= number_format($totalPendapatan, 2, ',', '.'); ?></td>
                                        <td>Rp. <?= number_format($totalOperasional, 2, ',', '.'); ?></td>
                                    </tr>
                                    <tr>
                                        <th colspan="3"><center>Saldo Akhir</center></th>
                                        <td colspan="2">Rp. <?= number_format($var_saldo, 2, ',', '.'); ?></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
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

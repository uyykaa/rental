<?php
session_start();
?>
<!-- laporan-pengeluaran-kas.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Masukkan meta, title, dan CSS yang diperlukan -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Laporan Pengeluaran Kas</title>

    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <!-- Css khusus untuk mencetak -->
    <style type="text/css" media="print">
        /* Sembunyikan elemen yang tidak ingin dicetak */
        body * {
            visibility: hidden;
        }

        /* Kecuali elemen yang ingin dicetak */
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
    <?php
    require 'koneksi.php';
    ?>

    <!-- Main Content -->
    <div id="content">
        <?php require 'navbar.php'; ?>

        <!-- Tombol Cetak -->
        <button type="button" class="btn btn-success" style="margin:5px" onclick="window.print()">
            <i class="fa fa-print"> Cetak</i>
        </button><br>

        <div class="container">
            <div class="card shadow mb-3">
                <div class="card-header py-3 text-center">
                    <h4 class="m-0 font-weight-bold text-primary">GC PERSADA TRANSPORT</h4>
                    <h5>Laporan Pengeluaran Kas</h5>
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
                    <button type="button" class="btn btn-primary" style="margin:5px" onclick="applyFilter()">Filter</button>
                    <script>
                        function applyFilter() {
                            var tanggal_awal = document.getElementById('tanggal_awal').value;
                            var tanggal_akhir = document.getElementById('tanggal_akhir').value;
                            var url = 'laporan-pengeluaran-kas.php';
                            url += '?tanggal_awal=' + tanggal_awal + '&tanggal_akhir=' + tanggal_akhir;
                            window.location.href = url;
                        }
                    </script>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Id Operasional</th>
                                        <th>Nama Operasional</th>
                                        <th>Tanggal Operasional</th>
                                        <th>Harga</th>
                                        <th>Kuantitas</th>
                                        <th>Total Operasional</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $totaloperasional = 0;
                                    $tanggal_awal = isset($_GET['tanggal_awal']) ? $_GET['tanggal_awal'] : date('Y-m-d');
                                    $tanggal_akhir = isset($_GET['tanggal_akhir']) ? $_GET['tanggal_akhir'] : date('Y-m-d');

                                    // Query untuk mengambil data pengeluaran berdasarkan periode tanggal yang dipilih
                                    $queryPengeluaran = mysqli_query($koneksi, "SELECT * FROM operasional WHERE tanggal_operasional BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
                                    while ($data = $queryPengeluaran->fetch_assoc()) : ?>
                                        <tr>
                                            <td><?= $data['id_operasional'] ?></td>
                                            <td><?= $data['nama_operasional'] ?></td>
                                            <td><?= $data['tanggal_operasional'] ?></td>
                                            <td>Rp. <?= number_format($data['harga'], 2, ',', '.'); ?></td>
                                            <td><?= $data['kuantitas'] ?></td>
                                            <?php $jumlah = $data['harga'] * $data['kuantitas']; ?>
                                            <td>Rp. <?= number_format($jumlah, 2, ',', '.'); ?></td>
                                        </tr>
                                        <?php
                                        $totaloperasional += $jumlah;
                                        ?>
                                    <?php endwhile; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="5" style="text-align: right;">Total</th>
                                        <th>Rp. <?= number_format($totaloperasional, 2, ',', '.'); ?></th>
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

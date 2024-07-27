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

        .form-group input[type="date"] {
            flex: 1;
            min-width: 10px;
        }
    </style>
</head>

<body id="page-top">
    <div id="container">
        <?php
        $role = $_SESSION['role_id'];
        if ($role == '2') {
            require 'sidebar-pemilik.php';
        } else {
            require 'sidebar.php';
        }
        require 'navbar.php';
        ?>
        <div id="content">
            <div class="container-fluid">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 text-center">
                        <h4 class="m-0 font-weight-bold text-primary">GC PERSADA TRANSPORT</h4>
                        <h5>Laporan Perubahan Modal</h5>
                        <h6>Per <?php echo isset($_GET['tanggal_akhir']) ? date('d F Y', strtotime($_GET['tanggal_akhir'])) : date('d F Y'); ?></h6>
                    </div>
                    <div class="container-fluid">
                        <form method="GET" action="laporan-perubahan-modal.php">
                            <div class="form-group">
                                <label for="tanggal_awal">Tanggal Awal:</label>
                                <input type="date" class="form-control col-sm-2" id="tanggal_awal" name="tanggal_awal" value="<?php echo isset($_GET['tanggal_awal']) ? $_GET['tanggal_awal'] : date('Y-m-01'); ?>">
                            </div>
                            <div class="form-group">
                                <label for="tanggal_akhir">Tanggal Akhir:</label>
                                <input type="date" class="form-control col-sm-2" id="tanggal_akhir" name="tanggal_akhir" value="<?php echo isset($_GET['tanggal_akhir']) ? $_GET['tanggal_akhir'] : date('Y-m-d'); ?>">
                            </div>
                            <div class="form-group row ">
                                <button type="submit" class="btn btn-primary m-2"><i class="fa fa-filter"></i> Filter</button>
                                <button type="button" class="btn btn-success " onclick="window.print()"><i class="fa fa-print"></i> Cetak</button>
                                <a href="laporan-perubahan-modal.php" class="btn btn-warning m-2"><i class="fa fa-refresh"></i> Reset</a>
                            </div>
                        </form>

                        <!-- Laporan Perubahan Modal Section -->
                        <div class="container-fluid">
                            <?php
                            $tanggal_awal = isset($_GET['tanggal_awal']) ? $_GET['tanggal_awal'] : date('Y-m-01');
                            $tanggal_akhir = isset($_GET['tanggal_akhir']) ? $_GET['tanggal_akhir'] : date('Y-m-d');

                            $modal_awal = 0;
                            $laba_rugi = 0;
                            $total_pendapatan = 0;
                            $total_pengeluaran = 0;

                            // Fetch Modal Awal from modal table
                            $query_modal_awal = "SELECT SUM(nominal) as total_modal_awal FROM modal WHERE tanggal < '$tanggal_awal'";
                            $result_modal_awal = mysqli_query($koneksi, $query_modal_awal);
                            if ($result_modal_awal) {
                                $modal_awal_row = mysqli_fetch_assoc($result_modal_awal);
                                if ($modal_awal_row) {
                                    $modal_awal = $modal_awal_row['total_modal_awal'] ?? 0;
                                }
                            } else {
                                echo "Error: " . mysqli_error($koneksi);
                            }

                            // get total pendapatan from pendapatan sewa
                            $query_pendapatan = mysqli_query($koneksi, "SELECT * FROM pendapatan_sewa WHERE tgl_pendapatan BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
                            if ($query_pendapatan) {
                                foreach ($query_pendapatan as $pendapatan) {
                                    $total_pendapatan += $pendapatan['jumlah_pendapatan'];
                                }
                            } else {
                                echo "Error: " . mysqli_error($koneksi);
                            }

                            // get total pengeluaran from Operasional
                            $query_operasional = mysqli_query($koneksi, "SELECT * FROM operasional WHERE tanggal_operasional BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
                            if ($query_operasional) {
                                foreach ($query_operasional as $pengeluaran) {
                                    $total_pengeluaran += $pengeluaran['total_operasional'];
                                }
                            } else {
                                echo "Error: " . mysqli_error($koneksi);
                            }

                            $laba_rugi = $total_pendapatan - $total_pengeluaran;

                            // Calculate Modal Akhir
                            $modal_akhir = $modal_awal + $laba_rugi;

                            // Memeriksa apakah hari ini adalah akhir bulan
                            $today = date("Y-m-d");
                            $end_of_month = date("Y-m-t");

                            if ($today == $end_of_month) {
                                // Cek apakah sudah ada data modal untuk bulan ini
                                $cek_tanggal_modal = mysqli_query($koneksi, "SELECT * FROM modal WHERE nama_akun = 'Modal Laba' AND tanggal = '$today'");
                                if (mysqli_num_rows($cek_tanggal_modal) == 0) {
                                    // Insert modal akhir sebagai modal awal bulan berikutnya
                                    $tanggal_bulan_depan = date("Y-m-01", strtotime("+1 month", strtotime($today)));
                                    $query_insert_modal_awal = "INSERT INTO modal (tanggal, nama_akun, nominal) VALUES ('$tanggal_bulan_depan', 'Modal Awal', '$modal_akhir')";
                                    mysqli_query($koneksi, $query_insert_modal_awal);
                                }
                            }
                            ?>
                            <table class="table table-bordered report-table">
                                <tr>
                                    <td>Modal Awal</td>
                                    <td class="amount">Rp. <?php echo number_format($modal_awal, 2, ',', '.'); ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo $laba_rugi >= 0 ? 'Laba' : 'Rugi'; ?></td>
                                    <td class="amount">Rp. <?php echo number_format(abs($laba_rugi), 2, ',', '.'); ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Modal Akhir</strong></td>
                                    <td class="amount"><strong>Rp. <?php echo number_format($modal_akhir, 2, ',', '.'); ?></strong></td>
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

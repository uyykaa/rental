<?php
require 'cek-sesi.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="shortcut icon" href="img/logo.jpg">
  <title>SIA KAS GC PERSADA</title>
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <link href="css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body id="page-top">

  <?php
  require 'koneksi.php';
  require 'sidebar.php';

  try {
    $penggunaResult = mysqli_query($koneksi, "SELECT * FROM pengguna");
    if (!$penggunaResult) {
      throw new Exception("Query Error: " . mysqli_error($koneksi));
    }
    $pengguna = mysqli_num_rows($penggunaResult);

    $pengeluaranResult = mysqli_query($koneksi, "SELECT SUM(total_operasional) AS total_operasional FROM operasional WHERE tanggal_operasional = CURDATE()");
    if (!$pengeluaranResult) {
      throw new Exception("Query Error: " . mysqli_error($koneksi));
    }
    $pengeluaran_hari_ini = mysqli_fetch_assoc($pengeluaranResult)['total_operasional'];

    $pendapatan_sewa = mysqli_query($koneksi, "SELECT SUM(jumlah) AS total_pendapatan FROM pendapatan_sewa WHERE tgl_pendapatan = CURDATE()");
    if (!$pendapatan_sewa) {
      throw new Exception("Query Error: " . mysqli_error($koneksi));
    }
    $pendapatan_hari_ini = mysqli_fetch_assoc($pendapatan_sewa)['total_pendapatan'];

    $arraymasuk = [];
    $pendapatan = mysqli_query($koneksi, "SELECT jumlah_pendapatan FROM pendapatan_sewa");
    while ($masuk = mysqli_fetch_assoc($pendapatan)) {
      $arraymasuk[] = $masuk['jumlah_pendapatan'];
    }
    $pendapatan_sewa = array_sum($arraymasuk);

    $arraykeluar = [];
    $operasional = mysqli_query($koneksi, "SELECT total_operasional FROM operasional");
    while ($keluar = mysqli_fetch_assoc($operasional)) {
      $arraykeluar[] = $keluar['total_operasional'];
    }
    $jumlahkeluar = array_sum($arraykeluar);

    $uang = $pendapatan_sewa - $jumlahkeluar;

    // Data for chart
    $sekarang = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(jumlah_pendapatan) AS jumlah_pendapatan FROM jumlah_pendapatan WHERE tgl_pendapatan = CURDATE()"))['jumlah_pendapatan'];
    $satuhari = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(jumlah_pendapatan) AS jumlah_pendapatan FROM jumlah_pendapatan WHERE tgl_pendapatan = CURDATE() - INTERVAL 1 DAY"))['jumlah_pendapatan'];
    $duahari = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(jumlah_pendapatan) AS jumlah_pendapatan FROM jumlah_pendapatan WHERE tgl_pendapatan = CURDATE() - INTERVAL 2 DAY"))['jumljumlah_pendapatanah'];
    $tigahari = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(jumlah_pendapatan) AS jumlah_pendapatan FROM jumlah_pendapatan WHERE tgl_pendapatan = CURDATE() - INTERVAL 3 DAY"))['jumlah_pendapatan'];
    $empathari = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(jumlah_pendapatan) AS jumlah_pendapatan FROM pendapatan_sewa WHERE tgl_pendapatan = CURDATE() - INTERVAL 4 DAY"))['jumlah_pendapatan'];
    $limahari = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(jumlah_pendapatan) AS jumlah_pendapatan FROM pendapatan_sewa WHERE tgl_pendapatan = CURDATE() - INTERVAL 5 DAY"))['jumlah_pendapatan'];
    $enamhari = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(jumlah_pendapatan) AS jumlah_pendapatan FROM pendapatan_sewa WHERE tgl_pendapatan = CURDATE() - INTERVAL 6 DAY"))['jumlah_pendapatan'];
    $tujuhhari = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(jumlah_pendapatan) AS jumlah_pendapatan FROM pendapatan_sewa WHERE tgl_pendapatan = CURDATE() - INTERVAL 7 DAY"))['jumlah_pendapatan'];
  } catch (Exception $e) {
    echo "Error: " . $e->getMessage();
  }
  ?>

  <!-- Main Content -->
  <div id="content">

    <!-- Topbar -->
    <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
      <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
      </button>
      <h1>Selamat Datang, <?= $_SESSION['nama'] ?></h1>
      <?php require 'user.php'; ?>
    </nav>
    <!-- End of Topbar -->

    <!-- Begin Page Content -->
    <div class="container-fluid">

      <!-- Page Heading -->
      <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        <a href="export-semua.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Download Laporan</a>
      </div>

      <!-- Content Row -->
      <div class="row">

        <!-- Pendapatan Sewa Card -->
        <div class="col-xl-3 col-md-6 mb-4">
          <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
              <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                  <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Pendapatan Sewa</div>
                  <div class="h5 mb-0 font-weight-bold text-gray-800">Rp.<?= number_format($pendapatan_hari_ini, 2, ',', '.'); ?></div>
                </div>
                <div class="col-auto">
                  <i class="fas fa-calendar fa-2x text-gray-300"></i>
                </div>
              </div>
            </div> &nbsp Pendapatan Sewa : Rp.
            <?= number_format($pendapatan_sewa, 2, ',', '.'); ?>
          </div>
        </div>

        <!-- Biaya Operasional Card -->
        <div class="col-xl-3 col-md-6 mb-4">
          <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
              <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                  <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Biaya Operasional</div>
                  <div class="h5 mb-0 font-weight-bold text-gray-800">Rp.<?= number_format($pengeluaran_hari_ini, 2, ',', '.'); ?></div>
                </div>
                <div class="col-auto">
                  <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                </div>
              </div>
            </div> &nbsp Operasional : Rp.
            <?= number_format($jumlahkeluar, 2, ',', '.'); ?>
          </div>
        </div>

        <!-- Sisa Uang Card -->
        <div class="col-xl-3 col-md-6 mb-4">
          <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
              <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                  <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Sisa Uang</div>
                  <div class="h5 mb-0 font-weight-bold text-gray-800">Rp.<?= number_format($uang, 2, ',', '.'); ?></div>
                </div>
                <div class="col-auto">
                  <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                </div>
              </div>
            </div>

            <?php
            if ($uang < 1) {
              $warna = 'danger';
              $value = 0;
            } else if ($uang >= 1 && $uang < 1000000) {
              $warna = 'warning';
              $value = 1;
            } else {
              $warna = 'info';
              $value = $uang / 10000;
            }
            ?>

          </div>
        </div>
      </div>
    </div>
  </div>

</body>

</html>
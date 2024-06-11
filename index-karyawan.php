<?php
session_start();
if($_SESSION['jabatan']==" "){
  header("location:login.php?pesan=gagal");}
?>

<!DOCTYPE html>
<html lang="en">
<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="shortcut icon" href="img/uang.png">
  <title>SIA KAS GC PERSADA - Admin</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>
<body id="page-top">

<?php
require ('koneksi.php');
require ('sidebar-karyawan.php');

$operasional = mysqli_query($koneksi, "SELECT total_operasional FROM operasional where tanggal_operasional = CURDATE()");
$operasional = mysqli_fetch_array($operasional);
 
$pendapatan_sewa = mysqli_query($koneksi, "SELECT total_pendapatan FROM pendapatan_sewa where tgl_pendapatan_sewa = CURDATE()");
$pendapatan_sewa = mysqli_fetch_array($pendapatan_sewa);

$pendapatan_sewa=mysqli_query($koneksi,"SELECT * FROM pendapatan_sewa");
while ($masuk=mysqli_fetch_array($pendapatan_sewa)){
$arraymasuk[] = $masuk['total_pendapatan'];
}
$total_pendapatan = array_sum($arraymasuk);

$operasional=mysqli_query($koneksi,"SELECT * FROM operasional");
while ($keluar=mysqli_fetch_array($operasional)){
$arraykeluar[] = $keluar['total_operasional'];
}
$total_operasional = array_sum($arraykeluar);
$tampilKas = $total_pendapatan - $total_operasional;
?>

<!-- Main Content -->
  <div id="content">

<!-- Topbar -->
    <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

<!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

<!-- Topbar Search -->
<h3> Selamat Datang di Web <b>SIA Kas GC Persada </b></h3>

<?php require 'user.php'; ?>
</nav>
<!-- End of Topbar -->

<!-- Begin Page Content -->
    <div class="container-fluid">

<!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>          
    <div class="row">
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Pendapatan Sewa</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">Rp.<?=number_format($total_pendapatan,2,',','.');?></div>
                    </div>
    <div class="col-auto">
        <i class="fas fa-calendar fa-2x text-gray-300"></i>
            </div>
        </div>
    </div>
<!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">operasional</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">Rp.<?=number_format($total_operasional,2,',','.');?></div>
                    </div>
                <div class="col-auto">
                      <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div> 

<!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Sisa Uang</div>
                      <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                          <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">Rp.<?=number_format($tampilKas,2,',','.');?></div>
                        </div>   
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                    </div>
                  </div>

                </div><div class="col">
                          <div class="progress progress-sm mr-2">
	<?php
		if ($tampilKas < 1 ){
			$warna = 'danger';
			    $value = 0;
		}
			else if ($tampilKas >= 1 && $tampilKas < 1000000){
			$warna = 'warning';
				$value = 1;
		}
		else{
			$warna = 'info';
			$value = $tampilKas / 10000;
		};
						  
	?>		  
        <div class="progress-bar bg-<?=$warna?>" role="progressbar" style="width: 100%" aria-valuenow="<?=$value?>" aria-valuemin="0" aria-valuemax="100"><span><?=$value?> % </span></div>
                    </div>
                </div>
            </div>
        </div>

<div class="row">
      </div>
    </div>
  </div>
</div>

<!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

<?php require 'logout-modal.php'; ?>

  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="js/sb-admin-2.min.js"></script>

  </body>
</html>

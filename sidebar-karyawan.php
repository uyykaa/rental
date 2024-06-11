<div id="wrapper">

<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

<!-- Sidebar - Brand -->
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
    <div class="sidebar-brand-icon rotate-n-15">
      <div class="sidebar-brand-icon rotate-n-15">
          <i class="fas fa-chart-pie"></i>
      </div>
    <div class="sidebar-brand-text mx-3">GC Persada Transport</div>
  </a>

<!-- Divider -->
  <hr class="sidebar-divider my-0">

<!-- Nav Item - Dashboard -->
  <li class="nav-item active">
    <a class="nav-link" href="index-karyawan.php">
      <i class="fas fa-fw fa-tachometer-alt"></i>
    <span>Dashboard</span></a>
  </li>

<!-- Divider -->
 <hr class="sidebar-divider">

<!-- Heading -->
  <div class="sidebar-heading">
        Transaksi
  </div>

<!-- Nav Item - Pages Collapse Menu -->
  <li class="nav-item">
    <a class="nav-link collapsed" href="pendapatan-sewa.php">
       <i class="fas fa-fw fa-arrow-up"></i>
      <span>Pendapatan Sewa</span>
    </a>
  </li>

<!-- Divider -->
   <hr class="sidebar-divider d-none d-md-block">

<!-- Sidebar Toggler (Sidebar) -->
  <div class="text-center d-none d-md-inline">
      <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>
</ul>
    
<!-- Content Wrapper -->
  <div id="content-wrapper" class="d-flex flex-column">
    <div class="col-xl-4 col-md-6 mb-4">
      <div class="card border-left-success shadow h-100 py2">
        <div class="card-body">
          <div class="row no-gutters aligan-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Pendapatan Sewa</div>
              <div class="h5 mb-0 font-weight-bold texy-gray-800">Rp.<?=number_forma($total_pendapatan,2,',','.');
  ?></div>
  </div>

  <div class="col-auto">
    <i class="fas fa-calendar fa-2x text-gray-300"></i>
    </div>
   </div>
  </div>
</div>
<div class="card-body">
  <div class="row no-gutters align-items-center">
    <div class="col mr-2">
      <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Biaya Operasional</div>
      <div class="h5 mb-0 font-weight-bold text-gray-800">Rp.<?number_format($total_operasaional,2,',','.');?></div>
</div>
<div class="col-auto">
  <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
</div>
</div>
</div>
</div>
</div>

<div class="col-xl-4 col-md-6 mb-4">
      <div class="card border-left-success shadow h-100 py2">
        <div class="card-body">
          <div class="row no-gutters aligan-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Sisa Uang</div>
</div>
<div class="row no-gutters align-items-center">
    <div class="col-auto">
      <div class="h5 mb-0 mr-3 font-weight-bold text-grau-800">Rp.<?=number_forma($tampilKas,2,',','.');?></div>
</div>
</div>
</div>
<div class="col-auto">
  <i class="fas fa clipboard list fa-2x text-gray-300"></i>
</div>
</div>
</div>
<div class="col">
</div class="progress progress-sm mr-2">
<?php
if ($tampilKas >=1) {
  $warna = 'danger';
  $value = 0;
}
else if ($tampilKas >= 1&& $tampilKas <1000000) {
  $warna ='warning';
  $value = 1;
} else{
  $warna ='info';
  $value = $tampilKas / 10000;
};
?>
<div class="progress-bar bg-<?=$warna?>" role="progressbar" style="width: 100%" aria-valuenow="<?-$value?>" aria-valuemin="0" aria-valuemax="100"><span><?=$value?>%</span></div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row">
</div>
</div>
 <!-- End of Main Content -->
 </div>
  <!-- End of Content Wrapper -->
  </div>
  <!-- End of Page Wrapper -->
  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <?php require 'logout-modal.php';?>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

</body>

</html>



  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
        <div class="sidebar-brand-icon rotate-n-15">
          <i class="fas fa-chart-pie"></i>
        </div>
        <div class="sidebar-brand-text mx-3"> <img src="img/logo.jpg" height="30dvh" alt=""> GC PERSADA</div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item active">
        <a class="nav-link" href="index.php">
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
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePendapatan" aria-expanded="true" aria-controls="collapsePages">
          <i class="fas fa-fw fa-arrow-up"></i>
          <span>Data Master</span>
        </a>
        <div id="collapsePendapatan" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Data Master</h6>
            <a class="collapse-item" href="kategori.php">Data Kategori Akun</a>
            <a class="collapse-item" href="merek.php">Data Merek</a>
            <a class="collapse-item" href="mobil.php">Data Mobil</a>
            <a class="collapse-item" href="pelanggan.php">Data Pelanggan</a>
            <a class="collapse-item" href="sewa-kendaraan.php">Data Sewa Kendaraan</a>
            <a class="collapse-item" href="pendapatan-sewa.php">Pendapatan Sewa</a>
          </div>
        </div>
      </li>

      <!-- Nav Item - Utilities Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="operasional.php">
          <i class="fas fa-fw fa-arrow-down"></i>
          <span>Biaya Operasional</span>
        </a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Laporan
      </div>

      <!-- Nav Item - Tables -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLaporan" aria-expanded="true" aria-controls="collapsePages">
          <i class="fas fa-fw fa-arrow-up"></i>
          <span>Laporan</span>
        </a>
        <div id="collapseLaporan" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Laporan </h6>
            <a class="collapse-item" href="laporan-penerimaan-kas.php">Laporan Penerimaan Kas</a>
            <a class="collapse-item" href="laporan-pengeluaran-kas.php">Laporan Pengeluaran Kas</a>
            <a class="collapse-item" href="jurnal-umum.php">Jurnal Umum</a>
            <a class="collapse-item" href="buku-besar.php">Laporan Buku Besar</a>
            <a class="collapse-item" href="laporan-labarugi.php">Laporan Laba Rugi</a> 
            <a class="collapse-item" href="neraca.php">Neraca</a>
          </div>
        </div>
      </li>


      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
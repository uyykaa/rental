<div id="wrapper">

  <!-- Sidebar -->
  <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index-karyawan.php">
      <!-- Removed the icon div -->
      <div class="sidebar-brand-text mx-3">
        <img src="img/logo.jpg" height="30dvh" alt=""> GC PERSADA
      </div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
      <a class="nav-link" href="index-karyawan.php">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span>
      </a>
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
          <a class="collapse-item" href="modal.php">Modal</a>
          <a class="collapse-item" href="kategori.php">Data Kategori Akun</a>
          <a class="collapse-item" href="modal.php">Modal</a>
          <a class="collapse-item" href="mobil.php">Data Mobil</a>
          <a class="collapse-item" href="harga.php">Data Harga</a>
          <a class="collapse-item" href="pelanggan.php">Data Pelanggan</a>
          <a class="collapse-item" href="sewa-kendaraan.php">Data Sewa Kendaraan</a>
          <a class="collapse-item" href="pembayaran.php">Data Pembayaran</a>
          <a class="collapse-item" href="pendapatan-sewa.php">Pendapatan Sewa</a>
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

  <div id="content-wrapper" class="d-flex flex-column">

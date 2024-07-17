<?php
//require 'cek-sesi.php';
session_start();
?>
<!DOCTYPEhtml>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" conten="width=device-width,initial-scle=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Daftar Admin</title>

  <!-- Custom fonts for this template -->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <link href="css/sb-admin-2.min.css" rel="stylesheet">
  <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>
<body id="page-top">

<?php 
require 'koneksi.php';
if ($_SESSION['jabatan'] == "pemilik") {
    require 'sidebar-pemilik.php';
} else if ($_SESSION['jabatan'] == "karyawan") {
    require 'sidebar-karyawan.php';
} else {
    require 'sidebar-admin.php';}
?>

<!-- Main Content -->
  <div id="content">
    <?php require ('navbara.php'); ?>

    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- DataTales Example -->
        <div class="col-xl-8 col-l9-7">
            <button type="button" class="btn btn-success" style="margin:5px" data-toggle="modal" data-target="#myModalTambah"><i class="fa fa-plus"> Akun</i></button><br>
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Daftar </h6>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th width="15%">Id Operasional</th>
                  <th width="20%">Nama Operasional</th>
                  <th width="15%">Tanggal</th>
                  <th width="13%">Harga</th>
                  <th width="7%">Kuantitas</th>
                  <th width="25%">Total Operasional</th>
                  <th width="5%">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                $query = mysqli_query($koneksi,"SELECT * FROM operasional");
                while ($data = mysqli_fetch_assoc($query)) {
                ?>
                  <tr>
                    <td><?=$data['id_operasional']?></td>
                    <td><?=$data['nama_operasional']?></td>
                    <td><?=$data['tanggal_operasional']?></td>
                    <td>Rp. <?=number_format($data['harga'],2,',','.');?></td>
                    <td><?=$data['kuantitas']?></td>
                    <td>Rp. <?=number_format($data['total_operasional'],2,',','.');?></td>                
                    <td>
                      <a href="#" class="fa fa-edit btn btn-primary btn-md" data-toggle="modal" data-target="#myModal<?=$data['id_operasional'];?>"></a>
                    </td>
                  </tr>

                  <!-- Modal Edit Operasional -->
                  <div class="modal fade" id="myModal<?=$data['id_operasional'];?>" role="dialog">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">Ubah Data Pengeluaran</h4>
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                          <form role="form" action="proses-edit-operasional.php" method="get">
                            <?php
                            $id = $data['id_operasional']; 
                            $query_edit = mysqli_query($koneksi,"SELECT * FROM operasional WHERE id_operasional='$id'");
                            while ($row = mysqli_fetch_array($query_edit)) {  
                            ?>

                            <input type="hidden" name="id_operasional" value="<?=$row['id_operasional'];?>">
                            <div class="form-group">
                              <label>Id Operasional</label>
                              <input type="text" name="id_operasional" class="form-control" value="<?=$row['id_operasional'];?>" disabled>      
                            </div>

                            <div class="form-group">
                              <label>Nama_operasional</label>
                              <input type="text" name="nama_operasional" class="form-control" value="<?=$row['nama_operasional'];?>" readonly>      
                            </div>

                            <div class="form-group">
                              <label>Tanggal</label>
                              <input type="date" name="tanggal_operasional" class="form-control" value="<?=$row['tanggal_operasional'];?>">      
                            </div>

                            <div class="form-group">
                              <label>Harga</label>
                              <input type="number" name="harga" class="form-control" value="<?=$row['harga'];?>">      
                            </div>

                            <div class="form-group">
                              <label>Kuantitas</label>
                              <input type="number" name="kuantitas" class="form-control" value="<?=$row['kuantitas'];?>">      
                            </div>

                            <div class="modal-footer">  
                              <button type="submit" class="btn btn-success">Ubah</button>
                              <a href="hapus-operasional.php?id_operasional=<?=$row['id_operasional'];?>" onclick="return confirm('Anda Yakin Ingin Menghapus?')" class="btn btn-danger">Hapus</a>
                              <button type="button" class="btn btn-default" data-dismiss="modal">Keluar</button>
                            </div>
                            <?php 
                            }
                            ?>  
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php               
                } 
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <!-- /.container-fluid -->
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

  <!-- Page level plugins -->
  <script src="vendor/chart.js/Chart.min.js"></script>
  <script src="vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="js/demo/datatables-demo.js"></script>

</body>

</html>

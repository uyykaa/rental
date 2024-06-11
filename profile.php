<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>SIA KAS GC PERSADA</title>

  <!-- Custom fonts for this template -->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">


  <!-- Custom styles for this template -->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

  <!-- Custom styles for this page -->
  <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body id="page-top">
<?php require 'koneksi.php'; 
if ($_SESSION['jabatan'] == "pemilik") {
  require 'sidebar-pemilik.php';
} else if ($_SESSION['jabatan'] == "karyawan") {
  require 'sidebar-karyawan.php';
} else {
  require 'sidebar-bagiankeuangan.php';
}
?>

<!-- Main Content -->
     <div id="content">
<?php require 'navbar.php'; ?>

<!-- Begin Page Content -->
    <div class="container-fluid">
<button type="button" class="btn btn-success" style="margin:5px; visibility:<?=$lihat?>" data-toggle="modal" data-target="#myModalTambah"><i class="fa fa-plus"> User</i></button><br>

<!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Kelola Pengguna</h6>
  </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
             <thead>
                <tr>
                  <th>Id Pengguna</th>
                  <th>Nama</th>
                  <th>Jabatan</th>
                  <th>Email</th>
                  <th>Password</th>
					        <th>Aksi</th>
                </tr>
          </thead>
       <tfoot>
     </tfoot>
   <tbody>
<?php 
			
$query = mysqli_query($koneksi,"SELECT * FROM pengguna");
 $no = 1;
 while ($data = mysqli_fetch_assoc($query)) 
{
?>
<tr>
  <td><?=$data['id_pengguna']?></td>
  <td><?=$data['nama']?></td>
  <td><?=$data['jabatan']?></td>
  <td><?=$data['email']?></td>
  <td><?=$data['pass']?></td>
<td>

<!-- Button untuk modal -->
<a href="#" type="button" class=" fa fa-edit btn btn-primary btn-md" data-toggle="modal" data-target="#myModal<?php echo $data['id_pengguna']; ?>"></a>
</td>
</tr>

<div class="modal fade" id="myModal<?php echo $data['id_pengguna']; ?>" role="dialog">
<div class="modal-dialog">

<!-- Modal content-->
<div class="modal-content"> 
<div class="modal-header">
<h4 class="modal-title">Ubah Data Pengguna</h4>
<button type="button" class="close" data-dismiss="modal">&times;</button>
</div>
<div class="modal-body">
<form role="form" action="proses-edit-pengguna.php" method="get">

<?php
$id = $data['id_pengguna']; 
$query_edit = mysqli_query($koneksi,"SELECT * FROM pengguna WHERE id_pengguna='$id'");
//$result = mysqli_query($conn, $query);
while ($row = mysqli_fetch_array($query_edit)) {  
?>

<input type="hidden" name="id_pengguna" value="<?php echo $row['id_pengguna']; ?>">

<div class="form-group">
<label>ID</label>
<input type="text" name="id" class="form-control" value="<?php echo $row['id_pengguna']; ?>" disabled>      
</div>

<div class="form-group">
<label>Nama</label>
<input type="text" name="nama" class="form-control" value="<?php echo $row['nama']; ?>">      
</div>

<div class="form-group">
<label>Jabatan</label>
<input type="text" name="jabatan" class="form-control" value="<?php echo $row['jabatan']; ?>">      
</div>

<div class="form-group">
<label>Email</label>
<input type="text" name="email" class="form-control" value="<?php echo $row['email']; ?>">      
</div>

<div class="form-group">
<label>Password</label>
<input type="text" name="pass" class="form-control" value="<?php echo $row['pass']; ?>">      
</div>

<div class="modal-footer">  
<button type="submit" class="btn btn-success">Ubah</button>
<button type="button" class="btn btn-default" data-dismiss="modal">Keluar</button>
</div>
<?php 
}
//mysql_close($host);
?>  
       
</form>
</div>
</div>

</div>
</div>

<!-- Modal -->
  <div id="myModalTambah" class="modal fade" role="dialog">
    <div class="modal-dialog">

      <!-- konten modal-->
      <div class="modal-content">
        <!-- heading modal -->
        <div class="modal-header">
          <h4 class="modal-title">Tambah Pengguna</h4>
		    <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
<!-- body modal -->
<form action="tambah-pengguna.php" method="get">
  <div class="modal-body">
		Id pelanggan : 
         <input type="text" class="form-control" name="id_pengguna">
		Nama :  
         <input type="text" class="form-control" name="nama">
		Jabatan : 
         <input type="text" class="form-control" name="jabatan">
    Email : 
         <input type="text" class="form-control" name="email">
    Password : 
         <input type="text" class="form-control" name="pass">
  </div>
<!-- footer modal -->
 <div class="modal-footer">
		<button type="submit" class="btn btn-success" >Tambah</button>
		</form>
       <button type="button" class="btn btn-default" data-dismiss="modal">Keluar</button>
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
  <script src="vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="js/demo/datatables-demo.js"></script>

</body>

</html>
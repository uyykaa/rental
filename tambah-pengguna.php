<?php
//include('dbconnected.php');
include('koneksi.php');

$id = $_GET['id'];
$nama = $_GET['nama'];
$jabatan = $_GET['jabatan'];
$email = $_GET['email'];
$password = $_GET['password'];
$role_id = $_GET['role_id'];
$status = $_GET['status'];

//query update
$query = mysqli_query($koneksi,"INSERT INTO `users` (`id`, `nama`, `jabatan`, `email`, `password`, `role_id`, `status`) VALUES (null, '$id', '$nama', '$jabatan', '$email', '$password', '$role_id', '$status')");

if ($query) {
 # credirect ke page index
 header("location:pengguna.php"); 
}
else{
 echo "ERROR, data gagal diupdate". mysqli_error($koneksi);
}

//mysql_close($host);
?>
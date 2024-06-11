<?php
//include('dbconnected.php');
include('koneksi.php');

$id = $_GET['id_pengguna'];

//query update
$query = mysqli_query($koneksi,"DELETE FROM `pengguna` WHERE id_pengguna = '$id'");

if ($query) {
 # credirect ke page index
 header("location:karyawan.php"); 
}
else{
 echo "ERROR, data gagal diupdate". mysqli_error($koneksi);
}

//mysql_close($host);
?>
<?php
//include('dbconnected.php');
include('koneksi.php');

$id_pengguna = $_GET['id_pengguna'];
$nama = $_GET['nama'];
$jabatan = $_GET['jabatan'];
$email = $_GET['email'];
$pass = $_GET['pass'];

//query update
$query = mysqli_query($koneksi,"INSERT INTO `pengguna` (`id_pengguna`, `nama`, `jabatan`, `email`, `pas`) VALUES (null, '$id_pengguna', '$nama', '$jabatan', '$email', '$pass')");

if ($query) {
 # credirect ke page index
 header("location:profile.php"); 
}
else{
 echo "ERROR, data gagal diupdate". mysqli_error($koneksi);
}

//mysql_close($host);
?>
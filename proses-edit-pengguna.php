<?php
//include('dbconnected.php');
include('koneksi.php');

$id_pengguna = $_GET['id_pengguna'];
$nama = $_GET['nama'];
$jabatan = $_GET['jabatan'];
$email = $_GET['email'];
$pass = $_GET['pass'];

//query update
$query = mysqli_query($koneksi,"UPDATE user SET nama='$nama' , email='$email', pass='$pass' WHERE id_pengguna='$id_pengguna' ");

if ($query) {
 # credirect ke page index
 header("location:profile.php"); 
}
else{
 echo "ERROR, data gagal diupdate". mysql_error();
}

//mysql_close($host);
?>
<?php
//include('dbconnected.php');
include('koneksi.php');

$no_pelanggan = $_GET['no_pelanggan'];
$nama = $_GET['nama'];
$alamat = $_GET['alamat'];
$no_hp = $_GET['no_hp'];

//query update
$query = mysqli_query($koneksi,"INSERT INTO `pelanggan` (`no_pelanggan`, `nama`, `alamat`, `no_hp`) VALUES ('$no_pelanggan', '$nama', '$alamat', '$no_hp')");

if ($query) {
    // Redirect to the pelanggan.php page
    header("location:pelanggan.php"); 
} else {
    echo "ERROR, data gagal diupdate". mysqli_error($koneksi);
}

//mysql_close($host);
?>
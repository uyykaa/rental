<?php
//include('dbconnected.php');
include('koneksi.php');

$id = $_GET['id_pelanggan'];

//query update
$query = mysqli_query($koneksi, "DELETE FROM `pelanggan` WHERE id_pelanggan = '$id'");

if ($query) {
    header("location:bagiankeuangan.php");
} else if (condition_for_karyawan_page) {
    header("location:pelanggan.php");
} else {
    echo "ERROR, data gagal diupdate" . mysqli_error($koneksi);
}
//mysql_close($host);

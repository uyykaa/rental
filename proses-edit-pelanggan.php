<?php
//include('dbconnected.php');
include('koneksi.php');

$no_pelanggan = $_POST['no_pelanggan'];
$nama = $_POST['nama'];
$alamat = $_POST['alamat'];
$no_hp = $_POST['no_hp'];

//query update
$query = mysqli_query($koneksi, "UPDATE pelanggan SET nama='$nama' , alamat='$alamat', no_hp='$no_hp' WHERE no_pelanggan='$no_pelanggan' ");

if ($query) {
    # credirect ke page index
    header("location:pelanggan.php");
} else {
    echo "ERROR, data gagal diupdate" . mysqli_error($koneksi);
}

//mysql_close($host);

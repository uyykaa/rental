<?php
include('koneksi.php');

$id_akun = $_GET['id_akun'];

// Query to delete
$query = mysqli_query($koneksi, "DELETE FROM `kategori_akun` WHERE `id_akun` = '$id_akun'");

if ($query) {
    // Redirect to the operational page
    header("location:kategori.php");
} else {
    echo "ERROR, data gagal dihapus: " . mysqli_error($koneksi);
}
?>

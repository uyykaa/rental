<?php
include('koneksi.php');

$id_merek = $_GET['id_merek'];

// Query to delete
$query = mysqli_query($koneksi, "DELETE FROM `merek` WHERE `id_merek` = '$id_merek'");

if ($query) {
    // Redirect to the operational page
    header("location:merek.php");
} else {
    echo "ERROR, data gagal dihapus: " . mysqli_error($koneksi);
}
?>

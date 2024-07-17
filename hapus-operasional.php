<?php
include('koneksi.php');

$id_operasional = $_GET['id_operasional'];

// Query to delete
$query = mysqli_query($koneksi, "DELETE FROM `operasional` WHERE `id_operasional` = '$id_operasional'");

if ($query) {
    // Redirect to the operational page
    header("location:operasional.php");
} else {
    echo "ERROR, data gagal dihapus: " . mysqli_error($koneksi);
}
?>

<?php
require 'koneksi.php';

$id = $_GET['id_mobil'];

// Query delete
$query = "DELETE FROM mobil WHERE id_mobil = '$id'";

if (mysqli_query($koneksi, $query)) {
    // Redirect to the mobil page after deletion is successful
    header("location: mobil.php");
} else {
    // If an error occurs, display an error message
    echo "ERROR, data gagal dihapus: " . mysqli_error($koneksi);
}
?>
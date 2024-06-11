<?php
// Include the database connection file
require 'koneksi.php';

// Retrieve the variables from the POST request
$id_mobil = $_POST['id_mobil'];
$id_merek = $_POST['id_merek'];
$nama = $_POST['nama'];
$warna = $_POST['warna'];
$no_polisi = $_POST['no_polisi'];
$jumlah_set = $_POST['jumlah_set'];
$jenis_sewa = $_POST['jenis_sewa'];
$harga = $_POST['harga'];

// Query Update
$query = "UPDATE mobil SET 
    id_merek = '$id_merek', 
    nama = '$nama', 
    warna = '$warna', 
    no_polisi = '$no_polisi', 
    jumlah_set = '$jumlah_set',
    jenis_sewa = '$jenis_sewa',
    harga = '$harga'
    WHERE id_mobil = '$id_mobil'";

if (mysqli_query($koneksi, $query)) {
    // Redirect to the mobil page
    header("location:mobil.php");
} else {
    // Show an error message if the query failed
    echo "ERROR, data gagal diupdate: " . mysqli_error($koneksi);
}
?>
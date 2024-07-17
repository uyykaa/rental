<?php
// Include the database connection file
require 'koneksi.php';

// Retrieve the variables from the POST request and sanitize them
$id_mobil = mysqli_real_escape_string($koneksi, $_POST['id_mobil']);
$id_merek = mysqli_real_escape_string($koneksi, $_POST['id_merek']);
$nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
$warna = mysqli_real_escape_string($koneksi, $_POST['warna']);
$no_polisi = mysqli_real_escape_string($koneksi, $_POST['no_polisi']);
$jumlah_set = mysqli_real_escape_string($koneksi, $_POST['jumlah_set']);
$jenis_sewa = mysqli_real_escape_string($koneksi, $_POST['jenis_sewa']);
$lama_sewa = mysqli_real_escape_string($koneksi, $_POST['lama_sewa']);

// Query Update
$query = "UPDATE mobil SET 
    id_merek = '$id_merek', 
    nama = '$nama', 
    warna = '$warna', 
    no_polisi = '$no_polisi', 
    jumlah_set = '$jumlah_set',
    jenis_sewa = '$jenis_sewa',
    lama_sewa = '$lama_sewa',
    WHERE id_mobil = '$id_mobil'";

if (mysqli_query($koneksi, $query)) {
    // Redirect to the mobil page
    header("location:mobil.php");
} else {
    // Show an error message if the query failed
    echo "ERROR, data gagal diupdate: " . mysqli_error($koneksi);
}

// Close the database connection
mysqli_close($koneksi);

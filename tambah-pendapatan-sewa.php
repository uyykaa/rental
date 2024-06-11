<?php
require 'koneksi.php';

// Retrieve data from the form
$id_pendapatan = $_POST['id_pendapatan'];
$tgl_pendapatan = $_POST['tgl_pendapatan'];
$nama_akun = $_POST['nama_akun'];
$nama_pelanggan = $_POST['nama'];
$jumlah_pendapatan = $_POST['jumlah_pendapatan'];

// Insert data into the database
$query = "INSERT INTO pendapatan_sewa (id_pendapatan, tgl_pendapatan, nama_akun, nama, jumlah_pendapatan) 
          VALUES ('$id_pendapatan', '$tgl_pendapatan', '$nama_akun', '$nama_pelanggan', '$jumlah_pendapatan')";

if (mysqli_query($koneksi, $query)) {
    header("Location: pendapatan-sewa.php"); // Redirect to the page after adding pendapatan
} else {
    echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
}
?>

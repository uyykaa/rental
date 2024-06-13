<?php
require 'koneksi.php';

// Retrieve data from the form
$id_akun = $_POST['id_akun'];
$no_pelanggan = $_POST['no_pelanggan'];
$tgl_pendapatan = $_POST['tgl_pendapatan'];
$jumlah_pendapatan = $_POST['jumlah_pendapatan'];
$id_sewa = $_POST['id_sewa'];


$query_akun = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM kategori_akun WHERE id_akun = '$id_akun'"));

$nama_pendapatan = $query_akun['nama_akun'];


// Insert data into the database
$query = "INSERT INTO pendapatan_sewa (id_akun, no_pelanggan, id_sewa, nama_pendapatan,tgl_pendapatan,jumlah_pendapatan) VALUES ('$id_akun', '$no_pelanggan', '$id_sewa', '$nama_pendapatan', '$tgl_pendapatan', $jumlah_pendapatan)";



if (mysqli_query($koneksi, $query)) {
    header("Location: pendapatan-sewa.php"); // Redirect to the page after adding pendapatan
} else {
    echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
}

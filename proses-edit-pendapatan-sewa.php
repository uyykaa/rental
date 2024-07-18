<?php
// Include the database connection file
include('koneksi.php');

// Retrieve the variables from the POST request
$id_pendapatan = $_POST['id_pendapatan'];
$id_akun = $_POST['id_akun'];
$id_pelanggan = $_POST['id_pelanggan'];
$tgl_pendapatan = $_POST['tgl_pendapatan'];
$jumlah_pendapatan = $_POST['jumlah_pendapatan'];

// Query Update
$query = mysqli_query($koneksi, "UPDATE pendapatan_sewa SET 
        id_akun = '$id_akun', 
        id_pelanggan = '$id_pelanggan', 
        tgl_pendapatan = '$tgl_pendapatan', 
        jumlah_pendapatan = '$jumlah_pendapatan'
        WHERE id_pendapatan = '$id_pendapatan'");

if ($query) {
    // Redirect to the page pendapatan-sewa.php
    header("location:pendapatan-sewa.php");
} else {
    // Show an error message if the query failed
    echo "ERROR, data gagal diupdate: " . mysqli_error($koneksi);
}

// Close the database connection if needed
// mysqli_close($koneksi);

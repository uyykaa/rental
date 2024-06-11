<?php
// Include the database connection file
include('koneksi.php');

// Retrieve the variables from the POST request
$id_sewa = $_POST['id_sewa'];
$jenis_sewa = $_POST['jenis_sewa'];
$harga = $_POST['harga'];
$kuantitas = $_POST['kuantitas'];
$tgl_sewa = $_POST['tgl_sewa'];
$tgl_kembali = $_POST['tgl_kembali'];

// Query Update
$query = mysqli_query($koneksi, "UPDATE pendapatan_sewa SET 
        jenis_sewa = '$jenis_sewa', 
        harga = '$harga', 
        kuantitas = '$kuantitas', 
        tgl_sewa = '$tgl_sewa', 
        tgl_kembali = '$tgl_kembali'
        WHERE id_sewa = '$id_sewa'");

if ($query) {
    // Redirect to the page pendapatan-sewa.php
    header("location:pendapatan-sewa.php");
} else {
    // Show an error message if the query failed
    echo "ERROR, data gagal diupdate: " . mysqli_error($koneksi);
}

// Close the database connection if needed
// mysqli_close($koneksi);
?>
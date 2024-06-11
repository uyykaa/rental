<?php
require 'koneksi.php';

$id_mobil = $_POST['id_mobil'];
$nama = $_POST['nama'];
$warna = $_POST['warna'];
$no_polisi = $_POST['no_polisi'];
$jumlah_set = $_POST['jumlah_set'];
$jenis_sewa = $_POST['jenis_sewa'];
$harga = $_POST['harga'];
$id_merek = $_POST['id_merek'];

// Correct the SQL syntax to insert the record
$query = "INSERT INTO mobil (id_mobil, id_merek, nama, warna, no_polisi, jumlah_set, jenis_sewa, harga) 
           VALUES ('$id_mobil', '$id_merek', '$nama', '$warna', '$no_polisi', '$jumlah_set', '$jenis_sewa', '$harga')";

if (mysqli_query($koneksi, $query)) {
    // Redirect to the mobil page after adding the record successfully
    header("location: mobil.php");
} else {
    echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
}
?>
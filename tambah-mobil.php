<?php
require 'koneksi.php';

$nama = $_POST['nama'];
$warna = $_POST['warna'];
$no_polisi = $_POST['no_polisi'];
$jumlah_set = $_POST['jumlah_set'];
$jenis_sewa = $_POST['jenis_sewa'];
$lama_sewa = $_POST['lama_sewa'];
$id_merek = $_POST['id_merek'];

// Perbaiki sintaks SQL untuk menambahkan data ke tabel mobil
$query = "INSERT INTO mobil (id_merek, nama, warna, no_polisi, jumlah_set, jenis_sewa, lama_sewa) 
          VALUES ('$id_merek', '$nama', '$warna', '$no_polisi', '$jumlah_set', '$jenis_sewa', '$lama_sewa')";

if (mysqli_query($koneksi, $query)) {
    // Redirect ke halaman mobil setelah berhasil menambahkan data
    header("Location: mobil.php");
} else {
    echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
}

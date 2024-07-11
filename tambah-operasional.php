<?php
require 'koneksi.php';

$id_akun = $_POST['id_akun'];
$nama_operasional = $_POST['nama_operasional'];
$tanggal_operasional = $_POST['tanggal_operasional'];
$harga = $_POST['harga'];
$kuantitas = $_POST['kuantitas'];

// Hitung total_operasional
$total_operasional = $harga * $kuantitas;

$query = "INSERT INTO operasional (id_akun, nama_operasional, tanggal_operasional, harga, kuantitas, total_operasional) 
          VALUES ('$id_akun', '$nama_operasional', '$tanggal_operasional', '$harga', '$kuantitas', '$total_operasional')";

if (mysqli_query($koneksi, $query)) {
    echo "Tambah data berhasil";
    header("Location: operasional.php"); // Redirect ke halaman daftar operasional
    exit;
} else {
    echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
}
?> 

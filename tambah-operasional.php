<?php
require 'koneksi.php';

$id_operasional = $_GET['id_operasional'];
$id_akun = $_GET['id_akun'];
$nama_operasional = $_GET['nama_operasional'];
$tanggal_operasional = $_GET['tanggal_operasional'];
$harga = $_GET['harga'];
$kuantitas = $_GET['kuantitas'];
$total_operasional = $_GET['total_operasional'];

$query = "INSERT INTO operasional (id_operasional, id_akun, nama_operasional, tanggal_operasional, harga, kuantitas, total_operasional) 
          VALUES ('$id_operasional', '$id_akun', '$nama_operasional', '$tanggal_operasional', '$harga', '$kuantitas', '$total_operasional')";

if (mysqli_query($koneksi, $query)) {
    echo "New record created successfully";
    header("Location: operasional.php");
} else {
    echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
}
?>

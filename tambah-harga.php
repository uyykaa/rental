<?php
require 'koneksi.php';

$id_mobil = $_POST['id_mobil'];
$jenis_paket = $_POST['jenis_paket'];
$lama_sewa = $_POST['lama_sewa'];
$harga = $_POST['harga'];
$status = $_POST['status'];

$query = "INSERT INTO harga (id_mobil, jenis_paket, lama_sewa, harga, status) VALUES ('$id_mobil', '$jenis_paket', '$lama_sewa', '$harga', '$status')";

if (mysqli_query($koneksi, $query)) {
    echo "<script>alert('Data berhasil ditambahkan');window.location='harga.php';</script>";
} else {
    echo "<script>alert('Data gagal ditambahkan');window.location='harga.php';</script>";
}
?>

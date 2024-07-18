<?php
require 'koneksi.php';

$id_harga = $_POST['id_harga'];
$id_mobil = $_POST['id_mobil'];
$jenis_paket = $_POST['jenis_paket'];
$lama_sewa = $_POST['lama_sewa'];
$harga = $_POST['harga'];
$status = $_POST['status'];

$query = "UPDATE harga SET id_mobil='$id_mobil', jenis_paket='$jenis_paket', lama_sewa='$lama_sewa', harga='$harga', status='$status' WHERE id_harga='$id_harga'";

if (mysqli_query($koneksi, $query)) {
    echo "<script>alert('Data berhasil diubah');window.location='harga.php';</script>";
} else {
    echo "<script>alert('Data gagal diubah');window.location='harga.php';</script>";
}
?>

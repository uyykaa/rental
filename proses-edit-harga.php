<?php
require 'cek-sesi.php';
require 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_harga = $_POST['id_harga'];
    $id_mobil = $_POST['id_mobil'];
    $jenis_paket = $_POST['jenis_paket'];
    $lama_sewa = $_POST['lama_sewa'];
    $harga = $_POST['harga'];

    $query = mysqli_query($koneksi, "UPDATE harga SET id_mobil='$id_mobil', jenis_paket='$jenis_paket', lama_sewa='$lama_sewa', harga='$harga' WHERE id_harga='$id_harga'");

    if ($query) {
        echo "<script>alert('Data berhasil diubah!'); window.location = 'harga.php';</script>";
    } else {
        echo "<script>alert('Data gagal diubah!'); window.location = 'harga.php';</script>";
    }
} else {
    echo "<script>alert('Metode pengiriman tidak valid!'); window.location = 'harga.php';</script>";
}
?>

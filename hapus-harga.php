<?php
require 'cek-sesi.php';
require 'koneksi.php';

$id_harga = $_GET['id_harga'];

if (isset($id_harga)) {
    $query = mysqli_query($koneksi, "DELETE FROM harga WHERE id_harga='$id_harga'");

    if ($query) {
        echo "<script>alert('Data berhasil dihapus!'); window.location = 'harga.php';</script>";
    } else {
        echo "<script>alert('Data gagal dihapus!'); window.location = 'harga.php';</script>";
    }
} else {
    echo "<script>alert('ID harga tidak ditemukan!'); window.location = 'harga.php';</script>";
}
?>

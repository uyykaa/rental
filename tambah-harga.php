<?php
require 'cek-sesi.php';
require 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_mobil = $_POST['id_mobil'];
    $jenis_paket = $_POST['jenis_paket'];
    $lama_sewa = $_POST['lama_sewa'];
    $harga = $_POST['harga'];

    $query = mysqli_query($koneksi, "INSERT INTO harga (id_mobil, jenis_paket, lama_sewa, harga) VALUES ('$id_mobil', '$jenis_paket', '$lama_sewa', '$harga')");

    if ($query) {
        echo "<script>alert('Data berhasil ditambahkan!'); window.location = 'harga.php';</script>";
    } else {
        echo "<script>alert('Data gagal ditambahkan!'); window.location = 'harga.php';</script>";
    }
} else {
    echo "<script>alert('Metode pengiriman tidak valid!'); window.location = 'harga.php';</script>";
}
?>

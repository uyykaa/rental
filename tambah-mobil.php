<?php
require 'cek-sesi.php';
require 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_merek = $_POST['id_merek'];
    $nama = $_POST['nama'];
    $warna = $_POST['warna'];
    $no_polisi = $_POST['no_polisi'];
    $jumlah_set = $_POST['jumlah_set'];
    $status = 1; // Set status to 1 (available) by default

    $query = "INSERT INTO mobil (id_merek, nama, warna, no_polisi, jumlah_set, status) VALUES ('$id_merek', '$nama', '$warna', '$no_polisi', '$jumlah_set', '$status')";

    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Mobil berhasil ditambahkan'); window.location.href='mobil.php';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan mobil'); window.location.href='mobil.php';</script>";
    }
}
?>

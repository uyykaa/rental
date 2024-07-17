<?php
require 'cek-sesi.php';
require 'koneksi.php';

if (isset($_POST['id_merek']) && isset($_POST['merek'])) {
    $id_merek = mysqli_real_escape_string($koneksi, $_POST['id_merek']);
    $merek = mysqli_real_escape_string($koneksi, $_POST['merek']);

    $query = "UPDATE merek SET merek='$merek' WHERE id_merek='$id_merek'";
    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Data merek berhasil diubah');window.location='merek.php';</script>";
    } else {
        echo "<script>alert('Data merek gagal diubah');window.location='merek.php';</script>";
    }
}

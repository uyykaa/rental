<?php
include('koneksi.php');

$id_merek = $_POST['id_merek'];
$merek = $_POST['merek'];

// Query insert
$query = mysqli_query($koneksi, "INSERT INTO merek VALUES ('$id_merek', '$merek')");

if ($query) {
    // Redirect ke halaman profile jika berhasil
    header("location: merek.php");
} else {
    // Menampilkan pesan error jika gagal
    echo "ERROR, data gagal ditambahkan: " . mysqli_error($koneksi);
}

<?php
include('koneksi.php');

$merek = $_POST['merek'];

// Query insert, omitting the id_merek field to let it auto-increment
$query = mysqli_query($koneksi, "INSERT INTO merek (merek) VALUES ('$merek')");

if ($query) {
    // Redirect ke halaman profile jika berhasil
    header("location: merek.php");
} else {
    // Menampilkan pesan error jika gagal
    echo "ERROR, data gagal ditambahkan: " . mysqli_error($koneksi);
}
?>

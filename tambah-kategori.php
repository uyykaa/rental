<?php
require 'koneksi.php';

$id_akun = $_POST['id_akun'];
$nama_akun = $_POST['nama_akun'];

// Correct the SQL syntax
$query = "INSERT INTO kategori_akun (id_akun, nama_akun) VALUES ('$id_akun', '$nama_akun')";

if (mysqli_query($koneksi, $query)) {
    echo "New record created successfully";
    header("location: kategori.php");
} else {
    echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
}

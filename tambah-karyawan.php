<?php
require 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize inputs
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $alamat = mysqli_real_escape_string($koneksi, $_POST['alamat']);
    $kontak = mysqli_real_escape_string($koneksi, $_POST['kontak']);

    // Insert data into database
    $query = "INSERT INTO penyewa (nama, alamat,  kontak) VALUES ('$nama', '$alamat', '$kontak')";
    if (mysqli_query($koneksi, $query)) {
        echo "Data berhasil ditambahkan";
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
    }

    mysqli_close($koneksi);
} else {
    echo "Invalid request method.";
}
?>

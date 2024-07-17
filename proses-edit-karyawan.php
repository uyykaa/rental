<?php
require 'koneksi.php';

// Check if the form is submitted using POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data and sanitize inputs
    $id = mysqli_real_escape_string($koneksi, $_POST['id_pengguna']);
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $jabatan = mysqli_real_escape_string($koneksi, $_POST['jabatan']);
    $alamat = mysqli_real_escape_string($koneksi, $_POST['alamat']);
    $umur = mysqli_real_escape_string($koneksi, $_POST['umur']);
    $kontak = mysqli_real_escape_string($koneksi, $_POST['kontak']);

    // Update data in the database
    $query = "UPDATE pengguna SET nama='$nama', jabatan='$jabatan', alamat='$alamat', umur='$umur', kontak='$kontak' WHERE id_pengguna='$id' ";
    if (mysqli_query($koneksi, $query)) {
        // Redirect to penyewa.php after successful update
        header("location: penyewa.php"); 
        exit(); // Make sure to exit after redirection
    } else {
        // If an error occurs during update, display error message
        echo "ERROR: " . $query . "<br>" . mysqli_error($koneksi);
    }
} else {
    // If the form is not submitted using POST method, display an error message
    echo "Invalid request method.";
}
?>

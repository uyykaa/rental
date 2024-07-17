<?php
session_start();
require 'koneksi.php';

// Jika nomor belum diatur, mulai dari 300
if (!isset($_SESSION['no'])) {
    $_SESSION['no'] = 300;
} else {
    $_SESSION['no'] += 1;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tanggal = $_POST['tanggal'];
    $nama_akun = $_POST['nama_akun'];
    $nominal = $_POST['nominal'];

    // Insert the data into the modal table
    $query = "INSERT INTO modal (tanggal, nama_akun, nominal) VALUES ('$tanggal', '$nama_akun', '$nominal')";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        // Redirect to a success page or back to the form with a success message
        header("Location: index.php?message=success");
    } else {
        // Handle error if the query fails
        echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
    }
}
?>

<?php
require 'cek-sesi.php';
require 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_pelanggan = $_POST['id_pelanggan'];
    $id_sewa = $_POST['id_sewa'];
    $tanggal_bayar = $_POST['tanggal_bayar'];
    $denda = isset($_POST['denda']) ? $_POST['denda'] : 0;
    $total_bayar = isset($_POST['total_bayar']) ? $_POST['total_bayar'] : 0;
    

    // Fetch the total_harga for the selected sewa
    $sewa_query = mysqli_query($koneksi, "SELECT total_harga FROM pembayaran WHERE id_sewa='$id_sewa'");
    if ($sewa_query) {
        $sewa = mysqli_fetch_assoc($sewa_query);
        $total_harga = $sewa['total_harga'];
        // Calculate total_bayar
        $total_bayar = ($total_harga - $uang_muka) + $denda;

        // Insert into the database
        $query = "INSERT INTO pembayaran (no_pelanggan, id_sewa, tanggal_bayar, uang_muka, denda, total_bayar) VALUES ('$id_pelanggan', '$id_sewa', '$tanggal_bayar', '$uang_muka', '$denda', '$total_bayar')";
        if (mysqli_query($koneksi, $query)) {
            header("Location: pembayaran.php");
        } else {
            die("Query Error: " . mysqli_error($koneksi));
        }
    } else {
        die("Query Error: " . mysqli_error($koneksi));
    }
}
?>

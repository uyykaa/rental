<?php
require 'koneksi.php';

if (isset($_POST['no_bayar'])) {
    $no_bayar = $_POST['no_bayar'];
    // $id_sewa = $_POST['id_sewa'];
    $tanggal_bayar = $_POST['tanggal_bayar'];
    $uang_muka = $_POST['uang_muka'];
    $denda = $_POST['denda'];
    $harga = $_POST['total_harga'];

    $total_harga = $harga;
    $total_bayar = (($total_harga - $uang_muka) + $denda);

    // Update the pembayaran table
    $update_query = mysqli_query($koneksi, "UPDATE pembayaran SET tanggal_bayar='$tanggal_bayar', uang_muka='$uang_muka', denda='$denda', total_bayar='$total_bayar' WHERE no_bayar='$no_bayar'");
    if ($update_query) {
        header("Location: pembayaran.php");
        exit(); // Ensure script stops after redirection
    } else {
        die("Query Error: " . mysqli_error($koneksi));
    }
}

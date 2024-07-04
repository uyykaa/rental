<?php
require 'cek-sesi.php';
require 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $no_bayar = $_POST['no_bayar'];
    $id_sewa = $_POST['id_sewa'];
    $tanggal_bayar = $_POST['tanggal_bayar'];
    $uang_muka = $_POST['uang_muka'];
    $denda = $_POST['denda'];

    // Fetch the total_harga for the selected sewa
    $sewa_query = mysqli_query($koneksi, "SELECT total_harga FROM sewa_kendaraan WHERE id_sewa='$id_sewa'");
    if ($sewa_query) {
        $sewa = mysqli_fetch_assoc($sewa_query);
        $total_harga = $sewa['total_harga'];
        // Calculate total_bayar
        $total_bayar = ($total_harga - $uang_muka) + $denda;

        // Update the database
        $query = "UPDATE pembayaran SET id_sewa='$id_sewa', tanggal_bayar='$tanggal_bayar', uang_muka='$uang_muka', denda='$denda', total_bayar='$total_bayar' WHERE no_bayar='$no_bayar'";
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
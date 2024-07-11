<?php
require 'koneksi.php';

if (isset($_POST['no_bayar'])) {
    $no_bayar = $_POST['no_bayar'];
    $id_sewa = $_POST['id_sewa'];
    $tanggal_bayar = $_POST['tanggal_bayar'];
    $uang_muka = $_POST['uang_muka'];
    $denda = $_POST['denda'];

    // Debugging
    echo "no_bayar: $no_bayar, id_sewa: $id_sewa, tanggal_bayar: $tanggal_bayar, uang_muka: $uang_muka, denda: $denda";

    // Fetch total_harga for the selected sewa
    $sewa_query = mysqli_query($koneksi, "SELECT total_harga FROM sewa_kendaraan WHERE id_sewa='$id_sewa'");
    if (!$sewa_query) {
        die("Query Error: " . mysqli_error($koneksi));
    }

    $sewa_data = mysqli_fetch_assoc($sewa_query);
    $total_harga = $sewa_data['total_harga'];
    $total_bayar = (($total_harga - $uang_muka) + $denda);

    // Debugging
    echo "total_harga: $total_harga, total_bayar: $total_bayar";
 
    // Update the pembayaran table
    $update_query = mysqli_query($koneksi, "UPDATE pembayaran SET id_sewa='$id_sewa', tanggal_bayar='$tanggal_bayar', uang_muka='$uang_muka', denda='$denda', total_bayar='$total_bayar' WHERE no_bayar='$no_bayar'");
    if ($update_query) {
        header("Location: pembayaran.php");
        exit(); // Ensure script stops after redirection
    } else {
        die("Query Error: " . mysqli_error($koneksi));
    }
}
?>

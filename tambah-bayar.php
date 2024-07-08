<?php
require 'cek-sesi.php';
require 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $no_pelanggan = $_POST['no_pelanggan'];
    $id_sewa = $_POST['id_sewa'];
    $tanggal_bayar = $_POST['tanggal_bayar'];
    $uang_muka = $_POST['uang_muka'];
    $denda = $_POST['denda'];

    // Fetch the total_harga for the selected sewa
    $stmt = $koneksi->prepare("SELECT total_harga FROM sewa_kendaraan WHERE id_sewa=?");
    $stmt->bind_param("i", $id_sewa);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result && $result->num_rows > 0) {
        $sewa = $result->fetch_assoc();
        $total_harga = $sewa['total_harga'];
        $total_bayar = (($total_harga - $uang_muka) + $denda);

        // Insert into the database
        $stmt = $koneksi->prepare("INSERT INTO pembayaran (no_pelanggan, id_sewa, tanggal_bayar, uang_muka, denda, total_bayar) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iissii", $no_pelanggan, $id_sewa, $tanggal_bayar, $uang_muka, $denda, $total_bayar);
        if ($stmt->execute()) {
            header("Location: pembayaran.php");
        } else {
            die("Query Error: " . $stmt->error);
        }
    } else {
        die("Query Error: " . $koneksi->error);
    }
}
?>

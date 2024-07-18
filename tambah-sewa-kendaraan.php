<?php
require 'cek-sesi.php';
require 'koneksi.php';
// Initialize variables
$id_pelanggan = $_POST['id_pelanggan'];
$tgl_sewa = $_POST['tgl_sewa'];
$jenis_sewa = $_POST['jenis_sewa'];
$lama_sewa = $_POST['lama_sewa'];
$id_mobil = $_POST['id_mobil'];
$uang_muka = 0; // Initialize uang muka

// Fetch harga mobil
$query_harga = mysqli_query($koneksi, "SELECT harga FROM harga WHERE id_mobil = $id_mobil");
if (!$query_harga) {
    die('Query Error: ' . mysqli_error($koneksi));
}
$data_harga = mysqli_fetch_assoc($query_harga);
if (!$data_harga) {
    die('No data found for harga with id_mobil: ' . $id_mobil);
}
$harga = $data_harga['harga'];

// Calculate uang muka (setengah dari harga)
$uang_muka = $harga / 2;

// Hitung total harga
$total_harga = calculateTotal($harga, $lama_sewa);

// Insert data sewa ke database
$query = "INSERT INTO sewa_kendaraan (id_pelanggan, id_mobil, tgl_sewa, jenis_sewa, lama_sewa, harga, total_harga, status)
          VALUES ('$id_pelanggan', '$id_mobil', '$tgl_sewa', '$jenis_sewa', '$lama_sewa', '$harga', '$total_harga', '0')";

// Execute query and handle results
if (mysqli_query($koneksi, $query)) {
    // Update status mobil
    mysqli_query($koneksi, "UPDATE mobil SET status='0' WHERE id_mobil=$id_mobil");

    // Fetch the last inserted id_sewa
    $id_sewa = mysqli_insert_id($koneksi);

    // Insert data pembayaran
    $total_bayar = $total_harga - $uang_muka;
    $insert_pembayaran = "INSERT INTO pembayaran (tanggal_bayar, uang_muka, id_sewa, no_pelanggan, total_bayar, status) 
                          VALUES ('$tgl_sewa', '$uang_muka', '$id_sewa', '$id_pelanggan', '$total_bayar', '0')";
    if (mysqli_query($koneksi, $insert_pembayaran)) {
        header('Location: sewa-kendaraan.php');
        exit;
    } else {
        echo "Error inserting pembayaran: " . mysqli_error($koneksi);
    }
} else {
    echo "Error inserting sewa_kendaraan: " . mysqli_error($koneksi);
}

// Function to calculate total harga based on lama sewa
function calculateTotal($harga, $lama_sewa)
{
    if ($lama_sewa <= 24) {
        return $harga;
    } else {
        return $harga * ($lama_sewa / 24);
    }
}

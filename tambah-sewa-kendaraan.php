<?php
require 'cek-sesi.php';
require 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $no_pelanggan = $_POST['no_pelanggan'];
  $tgl_sewa = $_POST['tgl_sewa'];
  $jenis_sewa = $_POST['jenis_sewa'];
  $lama_sewa = $_POST['lama_sewa'];
  $id_mobil = $_POST['id_mobil'];
  $harga = 0;

  // Fetch harga mobil
  $query_harga = mysqli_query($koneksi, "SELECT harga FROM mobil WHERE id_mobil = $id_mobil");
  $data_harga = mysqli_fetch_assoc($query_harga);
  $harga = $data_harga['harga'];

  // Hitung total harga
  $total_harga = calculateTotal($harga, $lama_sewa);

  // Insert data sewa ke database
  $query = "INSERT INTO sewa_kendaraan (no_pelanggan, id_mobil, tgl_sewa, jenis_sewa, lama_sewa, harga, total_harga)
            VALUES ('$no_pelanggan', '$id_mobil', '$tgl_sewa', '$jenis_sewa', '$lama_sewa', '$harga', '$total_harga')";

  if (mysqli_query($koneksi, $query)) {
    header('Location: sewa-kendaraan.php');
  } else {
    echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
  }
}

function calculateTotal($harga, $lama_sewa) {
  if ($lama_sewa <= 24) {
    // Lama sewa kurang dari atau sama dengan 24 jam
    return $harga;
  } else {
    // Lama sewa lebih dari 24 jam
    return $harga * ($lama_sewa / 24);
  }
}
?>

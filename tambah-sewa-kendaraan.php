<?php
require 'cek-sesi.php';
require 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $no_pelanggan = $_POST['no_pelanggan'];
  $merek = $_POST['merek'];
  $tgl_sewa = $_POST['tgl_sewa'];
  $tgl_kembali = $_POST['tgl_kembali'];
  $lama_sewa = $_POST['lama_sewa'];
  $harga = $_POST['harga'];
  $denda = $_POST['denda'];
  

  // Calculate the total cost
  $total = calculateTotal($harga, $lama_sewa);

  // Insert the new rental into the database
  $query = "INSERT INTO sewa_kendaraan (no_pelanggan, merek, tgl_sewa, tgl_kembali, lama_sewa, harga, denda, total)
            VALUES ('$no_pelanggan', '$merek', '$tgl_sewa', '$tgl_kembali', '$lama_sewa', '$harga', '$denda', '$total')";
  if (mysqli_query($koneksi, $query)) {
    header('Location: sewa-kendaraan.php');
  } else {
    echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
  }
}

// Function to calculate the total cost
function calculateTotal($harga, $lama_sewa) {
  if ($lama_sewa <= 24) {
      // Lama sewa kurang dari atau sama dengan 24 jam
      return $harga * 1;
  } else {
      // Lama sewa lebih dari 24 jam
      return $harga * $lama_sewa;
  }
}
?>

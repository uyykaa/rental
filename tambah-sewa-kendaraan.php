<?php
require 'cek-sesi.php';
require 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $no_pelanggan = $_POST['no_pelanggan'];
  $tgl_sewa = $_POST['tgl_sewa'];
  $tgl_kembali = $_POST['tgl_kembali'];
  $lama_sewa = $_POST['lama_sewa'];
  $id_mobil = $_POST['id_mobil'];
  $harga = 0;

  // Calculate the total cost

  $qHarga = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT harga FROM mobil WHERE id_mobil = $id_mobil"));

  $harga = implode('', $qHarga);
  $total = calculateTotal($harga, $lama_sewa);


  // Insert the new rental into the database
  $query = "INSERT INTO sewa_kendaraan (tgl_sewa, tgl_kembali, id_mobil,no_pelanggan, lama_sewa, harga,  total_harga)
            VALUES ('$tgl_sewa', '$tgl_kembali','$id_mobil','$no_pelanggan', '$lama_sewa', '$harga', '$total')";

  if (mysqli_query($koneksi, $query)) {
    header('Location: sewa-kendaraan.php');
  } else {
    echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
  }
}

// Function to calculate the total cost
function calculateTotal($harga, $lama_sewa)
{
  if ($lama_sewa <= 24) {
    // Lama sewa kurang dari atau sama dengan 24 jam
    return $harga;
  } else {
    // Lama sewa lebih dari 24 jam
    return $harga * ($lama_sewa / 24);
  }
}

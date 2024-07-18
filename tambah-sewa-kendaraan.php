<?php
require 'cek-sesi.php';
require 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id_pelanggan = $_POST['id_pelanggan'];
  $tgl_sewa = $_POST['tgl_sewa'];
  $jenis_sewa = $_POST['jenis_sewa'];
  $lama_sewa = $_POST['lama_sewa'];
  $id_mobil = $_POST['id_mobil'];
  $harga = 0;
  $uang_muka = $_POST['uang_muka'];

  // Fetch harga mobil
  $query_harga = mysqli_query($koneksi, "SELECT harga FROM mobil WHERE id_mobil = $id_mobil");
  $data_harga = mysqli_fetch_assoc($query_harga);
  $harga = $data_harga['harga'];

  // Hitung total harga
  $total_harga = calculateTotal($harga, $lama_sewa);

  // Insert data sewa ke database
  $query = "INSERT INTO sewa_kendaraan (id_pelanggan, id_mobil, tgl_sewa, jenis_sewa, lama_sewa, harga, total_harga, status)
            VALUES ('$id_pelanggan', '$id_mobil', '$tgl_sewa', '$jenis_sewa', '$lama_sewa', '$harga', '$total_harga', '0')";


  if (mysqli_query($koneksi, $query)) {
    mysqli_query($koneksi, "UPDATE mobil SET status='0' WHERE id_mobil=$id_mobil");

    $pembayaran = mysqli_query($koneksi, "SELECT * FROM sewa_kendaraan ORDER BY id_sewa DESC LIMIT 1");
    $total_bayar = $total_harga - $uang_muka;
    foreach ($pembayaran as $row) {
      $id_sewa = $row['id_sewa'];
      mysqli_query($koneksi, "INSERT INTO pembayaran (tanggal_bayar, uang_muka,id_sewa,id_pelanggan,total_bayar,status) values('$tgl_sewa', '$uang_muka','$id_sewa', '$id_pelanggan', '$total_bayar', '0')");
    }

    header('Location: sewa-kendaraan.php');
  } else {
    echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
  }
}

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
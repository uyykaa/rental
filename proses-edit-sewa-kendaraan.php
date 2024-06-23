<?php
require 'cek-sesi.php';
require 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id_sewa = $_POST['id_sewa'];
  $id_mobil = $_POST['id_mobil'];
  $tgl_sewa = $_POST['tgl_sewa'];
  $tgl_kembali = $_POST['tgl_kembali'];
  $lama_sewa = $_POST['lama_sewa'];
  $harga = $_POST['harga'];
  $denda = $_POST['denda'];


  // Calculate the total cost
  $total = calculateTotal(intval($harga), intval($lama_sewa)) + intval($denda);


  // Insert the new rental into the database
  $query = "UPDATE sewa_kendaraan SET tgl_sewa='$tgl_sewa', tgl_kembali='$tgl_kembali', id_mobil='$id_mobil', lama_sewa='$lama_sewa', harga='$harga', denda='$denda', total_harga='$total' WHERE id_sewa='$id_sewa'";

  // var_dump($query);
  // die;

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
    return $harga * $lama_sewa;
  }
}


function konfirmasi($id)
{
  var_dump('masuk');
  die;
}

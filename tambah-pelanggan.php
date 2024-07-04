<?php
require 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $no_hp = $_POST['no_hp'];

    // Handle image upload
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["img"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if (move_uploaded_file($_FILES["img"]["tmp_name"], $target_file)) {
        $img = basename($_FILES["img"]["name"]);
    } else {
        $img = "default.jpg";
    }

    $query = "INSERT INTO pelanggan (nama, alamat, no_hp, img) VALUES ('$nama', '$alamat', '$no_hp', '$img')";
    mysqli_query($koneksi, $query);

    header('Location: pelanggan.php');
}
?>
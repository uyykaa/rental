<?php
require 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_pelanggan = $_POST['id_pelanggan'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $no_hp = $_POST['no_hp'];

    // Handle image upload if a new file is provided
    if (!empty($_FILES["img"]["name"])) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["img"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        if (move_uploaded_file($_FILES["img"]["tmp_name"], $target_file)) {
            $img = basename($_FILES["img"]["name"]);
        } else {
            $img = "default.jpg";
        }
        $query = "UPDATE pelanggan SET nama='$nama', alamat='$alamat', no_hp='$no_hp', img='$img' WHERE id_pelanggan='$id_pelanggan'";
    } else {
        $query = "UPDATE pelanggan SET nama='$nama', alamat='$alamat', no_hp='$no_hp' WHERE id_pelanggan='$id_pelanggan'";
    }

    mysqli_query($koneksi, $query);

    header('Location: pelanggan.php');
}

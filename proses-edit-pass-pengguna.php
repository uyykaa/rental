<?php
//include('dbconnected.php');
include('koneksi.php');

$id = $_POST['id'];
$password = md5($_POST['password']);
//query update
$query = mysqli_query($koneksi, "UPDATE users SET password='$password' WHERE id='$id'");

if ($query) {
    # credirect ke page index
    header("location:pengguna.php");
} else {
    echo "ERROR, data gagal diupdate" . mysqli_error($koneksi);
}

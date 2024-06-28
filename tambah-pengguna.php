<?php
//include('dbconnected.php');
include('koneksi.php');

$nama = $_POST['nama'];
$jabatan = $_POST['jabatan'];
$email = $_POST['email'];
$password = md5($_POST['password']);
$no_hp = $_POST['no_hp'];
$alamat = $_POST['alamat'];
$role_id = '';
$status = '1';


if ($jabatan == 'pemilik') {
    $role_id = '2';
} elseif ($jabatan == 'karyawan') {
    $role_id = '3';
} elseif ($jabatan == 'keuangan') {
    $role_id = '4';
} elseif ($jabatan == 'Admin') {
    $role_id = '1';
}

//query update
$query = mysqli_query($koneksi, "INSERT INTO users VALUES ('','$nama','$no_hp','$alamat', '$jabatan', '$email', '$password', '$role_id', '$status')");

if ($query) {
    # credirect ke page index
    header("location:pengguna.php");
} else {
    echo "ERROR, data gagal diupdate" . mysqli_error($koneksi);
}

//mysql_close($host);

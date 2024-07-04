<?php
//include('dbconnected.php');
include('koneksi.php');

$id = $_POST['id'];
$nama = $_POST['nama'];
$jabatan = $_POST['jabatan'];
$email = $_POST['email'];
$alamat = $_POST['alamat'];
$no_hp = $_POST['no_hp'];
$password = $_POST['password'];
$status = $_POST['status'];
$role_id = '';
$pass = '';

if (isset($password)) {
    $pass = md5($password);
} else {
    $query = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM users WHERE id='$id' Limit 1"));
    $pass = $query['password'];
}

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
$query = mysqli_query($koneksi, "UPDATE users SET nama='$nama', jabatan='$jabatan', email='$email',  alamat='$alamat', no_hp='$no_hp', role_id='$role_id', status='$status' WHERE id='$id'");

if ($query) {
    # credirect ke page index
    header("location:pengguna.php");
} else {
    echo "ERROR, data gagal diupdate" . mysqli_error($koneksi);
}

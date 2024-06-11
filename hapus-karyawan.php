<?php
include('koneksi.php');

$id = $_GET['id_pengguna'];

// Query delete
$query = mysqli_query($koneksi, "DELETE FROM pengguna WHERE id_pengguna = '$id'");

if ($query) {
    // Redirect ke halaman karyawan.php setelah penghapusan berhasil
    header("location: karyawan.php"); 
} else {
    // Jika terjadi kesalahan, tampilkan pesan error
    echo "ERROR, data gagal dihapus: " . mysqli_error($koneksi);
}

?>
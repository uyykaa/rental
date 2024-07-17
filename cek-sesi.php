<!-- cek apakah sudah login -->
<?php 
session_start();
require 'koneksi.php';

if(!isset($_SESSION['status']) || $_SESSION['status'] != "login"){
    header("Location: login.php?pesan=belum_login");
    exit();
}
?> 

<?php
// Mulai session
session_start();

// Cek apakah session terdaftar
if (isset($_SESSION['status'])) {
    // Session terdaftar, saatnya logout
    session_unset(); // Hapus semua variabel session
    session_destroy(); // Hapus session data


    header("location: login.php");
} else {
    // Variabel session salah, user tidak seharusnya ada di halaman ini. Kembalikan ke login
    echo '<script type="text/javascript">window.location.href = "login.php";</script>';
    exit; // Pastikan tidak ada kode yang dieksekusi setelah melakukan redirect
}

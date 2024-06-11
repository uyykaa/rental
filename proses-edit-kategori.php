<?php
    // Include the database connection file
    include('koneksi.php');
    
    // Retrieve the variables from the POST request
    $id_akun = $_POST['id_akun'];
    $nama_akun = $_POST['nama_akun'];
    
    // Query Update
    $query = mysqli_query($koneksi, "UPDATE kategori_akun SET nama_akun = '$nama_akun' WHERE id_akun = '$id_akun'");

    if ($query) {
        // Redirect to the 'kategori.php' page upon successful update
        header("location:kategori.php");
    } else {
        // Show an error message if the query failed
        echo "ERROR, data gagal diupdate: ". mysqli_error($koneksi);
    }
    
    // Close the database connection if needed
    // mysqli_close($koneksi);
?>
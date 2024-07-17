<?php
    // Include the database connection file
    include('koneksi.php');
    
    // Retrieve the variables from the GET request
    $id_operasional = $_GET['id_operasional'];
    $nama_operasional = $_GET['nama_operasional'];
    $tanggal_operasional = $_GET['tanggal_operasional'];
    $harga = $_GET['harga'];
    $kuantitas = $_GET['kuantitas'];
    
    //Hitung ulang "jumlah berdasarkan "harga dan "kuantitas" yang diperbarui 
     $total_operasional = $harga * $kuantitas;
    
    // Query Uptade
    $query = mysqli_query($koneksi, "UPDATE operasional SET 
        nama_operasional = '$nama_operasional', 
        tanggal_operasional = '$tanggal_operasional', 
        harga = '$harga', 
        kuantitas = '$kuantitas', 
        total_operasional = '$total_operasional' 
        WHERE id_operasional = '$id_operasional'");

    if ($query) {
        // Credirect ke page index
        header("location:operasional.php");
    } else {
        // Show an error message if the query failed
        echo "ERROR, data gagal diupdate: ". mysqli_error($koneksi);
    }
    
    // Close the database connection if needed
    // mysqli_close($koneksi);
    ?>
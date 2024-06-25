<?php


include 'koneksi.php';
//periksa apakah file ini tidak dipanggil secara langsung, jika dipanggil secara langsung
//maka user akan di kembalikan ke login.thml
if (!isset($_POST['email']) || !isset($_POST['pass'])) {
	echo '<meta http-equiv="refresh" content="0;url=login.php">';
	exit;
} else {
	//mengubah username dan password yang telah dimasukkan menjadi sebuah variabel dan meng-enkripsi password ke md5
	$email = $_POST['email'];
	$pass = md5($_POST['pass']);

	$query = mysqli_query($koneksi, "SELECT * FROM users WHERE email='$email' AND password='$pass'");

	//jika benar maka
	if (mysqli_num_rows($query) > 0) {
		//mulai session dan register variabelnya
		$sesi = mysqli_fetch_assoc($query);
		session_start();
		$_SESSION['email'] = $email;
		$_SESSION['id'] = $sesi['id'];
		$_SESSION['nama'] = $sesi['nama'];
		$_SESSION['role_id'] = $sesi['role_id'];
		$_SESSION['status'] = "login";

		if ($sesi['role_id'] == '1') {
			header("location:index.php");
		} elseif ($sesi['role_id'] == '2') {
			header("location:index-pemilik.php");
		}
	} else {
		//jika $rowCheck = 0, berarti email atau password salah, atau tidak terdaftar di database
		echo 'Invalid email or password, coba lagi deh.. ';
	}
}

// INSERT INTO users (email, password, role_id, status) VALUES ('admin123@gmail.com', MD5('admin'), '1','1');
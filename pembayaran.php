<?php
require 'cek-sesi.php';
require 'koneksi.php';


// Fetch brands for the dropdown menu
$brands_query = mysqli_query($koneksi, "SELECT sewa_kendaraan.*, mobil.nama AS nama_mobil, sewa_kendaraan.total_harga FROM sewa_kendaraan JOIN mobil ON sewa_kendaraan.id_mobil = mobil.id_mobil");
if (!$brands_query) {
    die("Query Error: " . mysqli_error($koneksi));
}
$brands = [];
while ($brand = mysqli_fetch_assoc($brands_query)) {
    $brands[] = $brand;
}

// Fetch customers for the dropdown menu
$customers_query = mysqli_query($koneksi, "SELECT * FROM pelanggan");
if (!$customers_query) {
    die("Query Error: " . mysqli_error($koneksi));
}
$customers = [];
while ($customer = mysqli_fetch_assoc($customers_query)) {
    $customers[] = $customer;
}

if (isset($_POST['btnKonfirmasi'])) {
    $id = $_POST['id'];
    $total_bayar = $_POST['total_bayar'];

    mysqli_query($koneksi, "UPDATE pembayaran SET status='1' WHERE id_sewa=$id");
    mysqli_query($koneksi, "UPDATE sewa_kendaraan SET is_paid='1' WHERE id_sewa=$id");

    $sewaKendaraan = mysqli_query($koneksi, "SELECT * FROM sewa_kendaraan WHERE id_sewa=$id");
    foreach ($sewaKendaraan as $row) {
        $id_akun = '4-01';
        $id_pelanggan = $row['id_pelanggan'];
        $id_sewa = $row['id_sewa'];
        $nama_pendapatan = 'Pendapatan Sewa';
        $tgl_pendapatan = date('Y-m-d');
        $jumlah_pendapatan = $total_bayar;
        $id_mobil = $row['id_mobil'];
        mysqli_query($koneksi, "INSERT INTO pendapatan_sewa values('','$id_akun','$id_pelanggan','$id_sewa','$nama_pendapatan','$tgl_pendapatan','$jumlah_pendapatan')");
        mysqli_query($koneksi, "UPDATE mobil SET status='1' WHERE id_mobil='$id_mobil'");
    }
} else if (isset($_POST['btnBatalkan'])) {
    $id = $_POST['id'];

    mysqli_query($koneksi, "UPDATE pembayaran SET is_sewa_done='0', status = '0' WHERE id_sewa = '$id'");
    mysqli_query($koneksi, "UPDATE sewa_kendaraan SET is_paid='0', status='0' WHERE id_sewa='$id'");
    mysqli_query($koneksi, "DELETE FROM pendapatan_sewa WHERE id_sewa='$id'");

    $que = mysqli_query($koneksi, "SELECT id_mobil FROM sewa_kendaraan WHERE id_sewa='$id'");

    foreach ($que as $row) {
        $id_mobil = $row['id_mobil'];
        mysqli_query($koneksi, "UPDATE mobil SET status='0' WHERE id_mobil='$id_mobil'");
    }

    header('location: sewa-kendaraan.php');

    // if (mysqli_query($koneksi, "UPDATE pembayaran SET status = '0' WHERE id_sewa = $id")) {
    //     $query = mysqli_query($koneksi, "DELETE FROM pendapatan_sewa WHERE id_sewa=$id");
    //     if (!$query) {
    //         die("Query Error: " . mysqli_error($koneksi));
    //     }
    // } else {
    //     die("Query Error: " . mysqli_error($koneksi));
    // }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>SIA KAS GC PERSADA</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
</head>

<body id="page-top">
    <?php
    $role = $_SESSION['role_id'];
    if ($role == '3') {
        require('sidebar-karyawan.php');
    } else {
        require('sidebar.php');
    }
    ?>
    <div id="content">
        <?php require 'navbar.php'; ?>
        <div class="container-fluid">
            <button type="button" class="btn btn-success" style="margin:5px" data-toggle="modal" data-target="#myModalTambah"><i class="fa fa-plus"></i> Bayar</button><br>
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Daftar Pembayaran</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Pelanggan</th>
                                    <th>Tgl Bayar</th>
                                    <th>Harga</th>
                                    <th>Uang Muka</th>
                                    <th>Denda</th>
                                    <th>Total Bayar</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tfoot></tfoot>
                            <tbody>
                                <?php
                                $no = 0;
                                $query = mysqli_query($koneksi, "SELECT pembayaran.*, pelanggan.nama AS nama_pelanggan, mobil.nama AS nama_mobil, sewa_kendaraan.total_harga FROM pembayaran 
                          JOIN pelanggan ON pembayaran.id_pelanggan = pelanggan.id_pelanggan 
                          JOIN sewa_kendaraan ON pembayaran.id_sewa = sewa_kendaraan.id_sewa
                          JOIN mobil ON sewa_kendaraan.id_mobil = mobil.id_mobil ORDER BY pembayaran.status ASC");
                                if ($query) {
                                    while ($data = mysqli_fetch_assoc($query)) {
                                ?>
                                        <tr>
                                            <td><?= ++$no; ?></td>
                                            <td><?= $data['nama_pelanggan'] ?></td>
                                            <td><?= $data['tanggal_bayar'] ?></td>
                                            <td>Rp.<?= number_format($data['total_harga'], 0, '', '.'); ?></td>
                                            <td>Rp.<?= number_format($data['uang_muka'], 0, '', '.'); ?></td>
                                            <td>Rp.<?= number_format($data['denda'], 0, '', '.'); ?></td>
                                            <td>Rp.<?= number_format($data['total_bayar'], 0, '', '.'); ?></td>
                                            <td>
                                                <?php
                                                if ($data['status'] === '1') {
                                                    echo '<span class="badge badge-pill badge-success">Selesai Pembayaran</span>';
                                                } else {
                                                    echo '<span class="badge badge-pill badge-warning">Belum Dibayar</span>';
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal<?= $data['id_sewa']; ?>"><i class="fa fa-edit"></i> Edit</a>
                                                <?php if ($data['status'] === '0' && $data['is_sewa_done'] == '1') { ?>
                                                    <a href="#" class="btn btn-success btn-sm" data-toggle="modal" data-target="#myModalKonfirmasi<?= $data['id_sewa']; ?>"><i class="fa fa-check"></i> Konfirmasi</a>
                                                <?php } elseif ($data['status'] == '1') { ?>
                                                    <a href="#" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#myModalBatalkan<?= $data['id_sewa']; ?>"><i class="fa fa-redo"></i> Batalkan</a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <div class="modal fade" id="myModal<?= $data['id_sewa']; ?>" role="dialog">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Ubah Data Bayar</h4>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form role="form" action="proses-edit-bayar.php" method="POST">
                                                            <input type="hidden" name="no_bayar" value="<?= $data['no_bayar']; ?>">

                                                            <div class="form-group">
                                                                <label>Tanggal Bayar</label>
                                                                <input type="date" name="tanggal_bayar" class="form-control" value="<?= $data['tanggal_bayar']; ?>">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Harga:</label>
                                                                <input type="text" class="form-control" value="<?= $data['total_harga']; ?>" name="total_harga">
                                                            </div>

                                                            <div class="form-group">
                                                                <label>Uang Muka</label>
                                                                <input type="text" name="uang_muka" class="form-control" value="<?= $data['uang_muka']; ?>">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Denda</label>
                                                                <input type="text" name="denda" class="form-control" value="<?= $data['denda']; ?>">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Total Bayar</label>
                                                                <input type="text" name="total_bayar" class="form-control" value="<?= $data['total_bayar']; ?>" readonly>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="submit" class="btn btn-success">Ubah</button>
                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Keluar</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal fade" id="myModalKonfirmasi<?= $data['id_sewa']; ?>" role="dialog">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Konfirmasi Pembayaran</h4>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form role="form" action="" method="POST">
                                                            <input type="hidden" name="id" value="<?= $data['id_sewa']; ?>">
                                                            <input type="hidden" name="total_bayar" value="<?= $data['total_bayar']; ?>">
                                                            <div class="form-group">
                                                                <h5>Apakah anda yakin ingin mengonfirmasi pembayaran ini?</h5>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="submit" name="btnKonfirmasi" class="btn btn-success">Ya</button>
                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Tidak</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal fade" id="myModalBatalkan<?= $data['id_sewa']; ?>" role="dialog">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Batalkan Pembayaran</h4>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form role="form" action="" method="POST">
                                                            <input type="hidden" name="id" value="<?= $data['id_sewa']; ?>">
                                                            <div class="form-group">
                                                                <h5>Apakah anda yakin ingin membatalkan pembayaran ini?</h5>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="submit" name="btnBatalkan" class="btn btn-success">Ya</button>
                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Tidak</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                <?php }
                                } else {
                                    die("Query Error: " . mysqli_error($koneksi));
                                } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div id="myModalTambah" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Tambah Pembayaran</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <form action="tambah-bayar.php" method="POST" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label>Nama Pelanggan:</label>
                                    <select name="id_pelanggan" class="form-control">
                                        <option value="">--- Pilih Pelanggan ---</option>
                                        <?php foreach ($customers as $customer) : ?>
                                            <option value="<?= $customer['id_pelanggan'] ?>"><?= $customer['nama'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Harga:</label>
                                    <select name="id_sewa" class="form-control">
                                        <option value="">--- Pilih Mobil ---</option>
                                        <?php foreach ($brands as $brand) : ?>
                                            <option value="<?= $brand['id_sewa'] ?>"><?= $brand['nama_mobil'] ?> | <?= $brand['total_harga'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Tanggal Bayar:</label>
                                    <input type="date" name="tanggal_bayar" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Uang Muka:</label>
                                    <input type="number" name="uang_muka" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Denda:</label>
                                    <input type="number" name="denda" class="form-control">
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-success">Tambah</button>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Keluar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="js/demo/datatables-demo.js"></script>
</body>

</html>
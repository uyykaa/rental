<?php
require 'cek-sesi.php';
require 'koneksi.php';

function calculateTotal($harga, $lama_sewa, $denda)
{
  // Ensure the inputs are numeric
  $harga = intval($harga) ? $harga : 0;
  $lama_sewa = intval($lama_sewa) ? $lama_sewa : 0;
  $denda = intval($denda) ? $denda : 0;

  if ($lama_sewa <= 24) {
    // Lama sewa kurang dari atau sama dengan 24 jam
    return $harga * 1 + $denda;
  } else {
    // Lama sewa lebih dari 24 jam, hitung berapa hari dan jam yang dibutuhkan
    $hari = floor($lama_sewa / 24);
    $jam = $lama_sewa % 24;

    // Jika ada sisa jam, tambahkan harga untuk satu hari tambahan
    if ($jam > 0) {
      return ($harga * $hari) + $harga + $denda;
    } else {
      return ($harga * $hari) + $denda;
    }
  }
}

// Fetch brands for the dropdown menu
$brands_query = mysqli_query($koneksi, "SELECT * FROM merek");
$brands = [];
while ($brand = mysqli_fetch_assoc($brands_query)) {
  $brands[] = $brand;
}

// Fetch customers for the dropdown menu
$customers_query = mysqli_query($koneksi, "SELECT * FROM pelanggan");
$customers = [];
while ($customer = mysqli_fetch_assoc($customers_query)) {
  $customers[] = $customer;
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
  <?php require 'sidebar.php'; ?>
  <div id="content">
    <?php require 'navbar.php'; ?>
    <div class="container-fluid">
      <button type="button" class="btn btn-success" style="margin:5px" data-toggle="modal" data-target="#myModalTambah"><i class="fa fa-plus"> Sewa</i></button><br>
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">Daftar Sewa</h6>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama Pelanggan</th>
                  <th>Mobil</th>
                  <th>Tgl Sewa</th>
                  <th>Tgl Kembali</th>
                  <th>Lama Sewa</th>
                  <th>Harga</th>
                  <th>Denda</th>
                  <th>Total Harga </th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $query = mysqli_query($koneksi, "SELECT sewa_kendaraan.*, pelanggan.nama, mobil.nama AS nama_mobil FROM sewa_kendaraan 
                  JOIN pelanggan ON sewa_kendaraan.no_pelanggan = pelanggan.no_pelanggan 
                  JOIN mobil ON mobil.id_mobil = sewa_kendaraan.id_mobil");
                while ($data = mysqli_fetch_assoc($query)) {
                ?>
                  <tr>
                    <td><?= $data['id_sewa'] ?></td>
                    <td><?= $data['nama'] ?></td>
                    <td><?= $data['nama_mobil'] ?></td>
                    <td><?= $data['tgl_sewa'] ?></td>
                    <td><?= $data['tgl_kembali'] ?></td>
                    <td><?= $data['lama_sewa'] ?></td>
                    <td><?= $data['harga'] ?></td>
                    <td><?= $data['denda'] ?></td>
                    <td><?= $data['total_harga'] ?></td>
                    <td>
                      <a href="#" type="button" class="fa fa-edit btn btn-primary btn-md" data-toggle="modal" data-target="#myModal<?= $data['id_sewa']; ?>">Edit</a>
                    </td>
                  </tr>
                  <div class="modal fade" id="myModal<?= $data['id_sewa']; ?>" role="dialog">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">Ubah Data Sewa</h4>
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                          <form role="form" action="proses-edit-sewa-kendaraan.php" method="POST">
                            <?php
                            $id = $data['id_sewa'];
                            $query_edit = mysqli_query($koneksi, "SELECT * FROM sewa_kendaraan WHERE id_sewa='$id'");
                            while ($row = mysqli_fetch_array($query_edit)) {
                            ?>
                              <input type="hidden" name="id_sewa" value="<?= $row['id_sewa']; ?>">
                              <div class="form-group">
                                <label>Merek:</label>
                                <select name="id_mobil" class="form-control" id="id_mobil">
                                  <?php
                                  $idMobil = $row['id_mobil'];
                                  $query_mobil = mysqli_query($koneksi, "SELECT * FROM mobil");
                                  while ($brand = mysqli_fetch_array($query_mobil)) {
                                    if ($row['id_mobil'] == $brand['id_mobil']) { ?>
                                      <option value="<?= $brand['id_mobil']; ?>" selected><?php echo $brand['nama'];
                                                                                          echo " | ";
                                                                                          echo $brand['no_polisi'];
                                                                                          ?></option>
                                    <?php } else { ?>
                                      <option value="<?= $brand['id_mobil']; ?>"><?php echo $brand['nama'];
                                                                                  echo " | ";
                                                                                  echo $brand['no_polisi'];
                                                                                  ?></option>
                                    <?php } ?>
                                  <?php } ?>
                                </select>
                              </div>
                              <div class="form-group">
                                <label>Tgl Sewa</label>
                                <input type="date" name="tgl_sewa" class="form-control" value="<?= $row['tgl_sewa']; ?>">
                              </div>
                              <div class="form-group">
                                <label>Tgl Kembali</label>
                                <input type="date" name="tgl_kembali" class="form-control" value="<?= $row['tgl_kembali']; ?>">
                              </div>
                              <div class="form-group">
                                <label>Lama Sewa</label>
                                <select name="lama_sewa" class="form-control">
                                  <option value="<?= $row['lama_sewa']; ?>" selected><?= $row['lama_sewa'] ?></option>
                                  <option value="12">12 Jam</option>
                                  <option value="18">18 Jam</option>
                                  <option value="24">24 Jam</option>
                                  <option value="48">2 </option>
                                  <option value="72">3 </option>
                                  <option value="96">4 </option>
                                  <option value="120">5 </option>
                                  <option value="144">6 </option>
                                  <option value="168">7 </option>
                                </select>
                              </div>
                              <div class="form-group">
                                <label>Harga:</label>
                                <input type="number" class="form-control" name="harga" id="harga" value="<?= $row['harga']; ?>">
                              </div>
                              <div class="form-group">
                                <label>Denda</label>
                                <input type="number" name="denda" class="form-control" value="<?= $row['denda']; ?>">
                              </div>
                            <?php
                            }
                            ?>
                            <div class="modal-footer">
                              <button type="submit" class="btn btn-success">Simpan</button>
                              <button type="button" class="btn btn-default" data-dismiss="modal">Keluar</button>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <div id="myModalTambah" class="modal fade" role="dialog">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Tambah Sewa</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form action="tambah-sewa-kendaraan.php" method="POST">
              <div class="modal-body">
                <div class="form-group">
                  <label>Nama Pelanggan:</label>
                  <select name="no_pelanggan" class="form-control">
                    <?php foreach ($customers as $customer) { ?>
                      <option value="<?= $customer['no_pelanggan']; ?>"><?= $customer['nama']; ?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="form-group">
                  <label>Mobil :</label>
                  <select name="id_mobil" class="form-control" id="id_mobil">
                    <option value="" disabled selected>pilih kendaraan...</option>
                    <?php
                    $query_mobil = mysqli_query($koneksi, "SELECT mobil.*, merek.merek FROM mobil JOIN merek ON mobil.id_merek = merek.id_merek");
                    while ($brand = mysqli_fetch_array($query_mobil)) { ?>
                      <option value="<?= $brand['id_mobil']; ?>"><?php echo $brand['nama'];
                                                                  echo " | ";
                                                                  echo $brand['no_polisi'];
                                                                  ?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="form-group">
                  <label>Tanggal Sewa:</label>
                  <input type="date" class="form-control" name="tgl_sewa">
                </div>
                <div class="form-group">
                  <label>Tanggal Kembali:</label>
                  <input type="date" class="form-control" name="tgl_kembali">
                </div>
                <div class="form-group">
                  <label>Lama Sewa:</label>
                  <select name="lama_sewa" class="form-control">
                    <option value="12">12 Jam</option>
                    <option value="18">18 Jam</option>
                    <option value="24">24 Jam</option>
                    <option value="48">2 Hari</option>
                    <option value="72">3 Hari</option>
                    <option value="96">4 Hari</option>
                    <option value="120">5 Hari</option>
                    <option value="144">6 Hari</option>
                    <option value="168">7 Hari</option>
                  </select>
                </div>
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

    <?php require 'footer.php'; ?>
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

  <script>
    $(document).ready(function() {
      $('#id_mobil').change(function() {
        var id_mobil = $(this).val();
        $.ajax({
          url: 'get_harga.php',
          method: 'POST',
          data: {
            id_mobil: id_mobil
          },
          dataType: 'json',
          success: function(data) {
            $('#harga').val(data.harga);
          }
        });
      });
    });
  </script>
</body>

</html>
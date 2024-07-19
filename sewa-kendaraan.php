<?php
require 'cek-sesi.php';
require 'koneksi.php';


$currDate = date('Y-m-d');

function convert_time($time)
{
  if ($time <= 24) {
    echo "$time Jam";
  } else {
    $hari = $time / 24;
    echo "$hari Hari";
  }
}

if (isset($_POST['id_mobil'])) {
  $id_mobil = $_POST['id_mobil'];
  $query = mysqli_query($koneksi, "SELECT harga FROM mobil WHERE id_mobil = '$id_mobil'");
  if ($query) {
    $result = mysqli_fetch_assoc($query);
    echo $result['harga'];
  } else {
    echo 'Error fetching price';
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


if (array_key_exists('btnKonfirmasi', $_POST)) {
  $id = $_POST['id'];
  mysqli_query($koneksi, "UPDATE sewa_kendaraan SET status = '1' WHERE id_sewa = $id");
  mysqli_query($koneksi, "UPDATE pembayaran SET is_sewa_done = '1' WHERE id_sewa = $id");
  header("location:pembayaran.php");
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
  <script src="vendor/jquery/jquery.min.js"></script> <!-- Add this line -->
</head>

<script>
  function getMobil(str) {
    if (str == "") {
      document.getElementById("id_mobil_hint").innerHTML = "";
      return;
    } else {
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          document.getElementById("id_mobil_hint").innerHTML = this.responseText;
        }
      };
      xmlhttp.open("GET", "test_db.php?q=" + str, true);
      xmlhttp.send();
    }
  }

  function getPaket(str, id) {
    if (str == "") {
      document.getElementById("id_paket_hint").innerHTML = "";
      return;
    } else {
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          document.getElementById("id_paket_hint").innerHTML = this.responseText;
        }
      };
      xmlhttp.open("GET", "test_paket_db.php?q='" + str + "'&id=" + id, true);
      xmlhttp.send();
    }
  }
</script>


<body id="page-top">
  <?php $role = $_SESSION['role_id'];
  $role == '3' ? require('sidebar-karyawan.php') : require('sidebar.php') ?>
  <div id="content">
    <?php require 'navbar.php'; ?>
    <div class="container-fluid">
      <button type="button" class="btn btn-success" style="margin:5px" data-toggle="modal" data-target="#myModalTambah"><i class="fa fa-plus"></i> Sewa</button><br>
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
                  <th>Tgl Sewa</th>
                  <th>Lama Sewa</th>
                  <th>Status </th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tfoot>
              </tfoot>
              <tbody>
                <?php
                $no = 0;
                $query = mysqli_query($koneksi, "SELECT sewa_kendaraan.*, pelanggan.nama, mobil.nama AS nama_mobil, mobil.no_polisi AS plat_mobil FROM sewa_kendaraan 
                JOIN pelanggan ON sewa_kendaraan.id_pelanggan = pelanggan.id_pelanggan 
                JOIN mobil ON mobil.id_mobil = sewa_kendaraan.id_mobil ORDER BY status asc");
                while ($data = mysqli_fetch_assoc($query)) {
                ?>
                  <tr>
                    <td><?= $no += 1; ?></td>
                    <td><?= $data['nama'] ?></td>
                    <td><?= $data['tgl_sewa'] ?></td>
                    <td><?= convert_time($data['lama_sewa']) ?></td>
                    <td>
                      <?php
                      // $endDate = date('Y-m-d', strtotime($data['tgl_sewa'] . ' + ' . $data['lama_sewa'] . ' days'));
                      $endDate = '';
                      if ($data['lama_sewa'] > 23) {
                        $lama_hari = $data['lama_sewa'] / 24;
                        $addDate = strtotime("+$lama_hari day", strtotime($data['tgl_sewa']));
                        $endDate = date('Y-m-d', $addDate);
                      } else {
                        $endDate = $data['tgl_sewa'];
                      }

                      if ($data['status'] == '1') {
                        echo '<span class="badge badge-pill badge-success">Sewa selesai</span>';
                      } elseif ($currDate > $endDate) {
                        echo '<span class="badge badge-pill badge-danger">Terlambat</span>';
                      } elseif ($currDate < $endDate) {
                        echo '<span class="badge badge-pill badge-primary">Sewa berlangsung</span>';
                      } elseif ($currDate == $endDate) {
                        echo '<span class="badge badge-pill badge-warning">Sewa berakhir hari ini</span>';
                      }
                      ?>
                    </td>
                    <td>
                      <?php if ($data['status'] == 1) { ?>
                        <a href="#" type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalDetail<?= $data['id_sewa']; ?>"><i class="fa fa-circle-info"></i> Detail</a>
                      <?php } elseif ($data['status'] == 0 && $data['is_paid'] == 0) { ?>
                        <a href="#" type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalDetail<?= $data['id_sewa']; ?>"><i class="fa fa-circle-info"></i> Detail</a>
                        <a href="#" type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal<?= $data['id_sewa']; ?>"><i class="fa fa-edit"></i> Edit</a>
                      <?php } ?>
                      <?php
                      if ($data['status'] == '0' && $currDate >= $endDate) {
                      ?>
                        <a href="#" class="btn btn-success btn-sm" data-toggle="modal" data-target="#myModalKonfirmasi<?= $data['id_sewa']; ?>"><i class="fa fa-check"></i> Konfirmasi</a>
                      <?php } ?>
                    </td>
                  </tr>
                  <!-- Modal Edit -->
                  <div class=" modal fade" id="myModal<?= $data['id_sewa']; ?>" role="dialog">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">Ubah Data Sewa</h4>
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
                                      <option value="<?= $brand['id_mobil']; ?>" selected>
                                        <?php echo $brand['nama'];
                                        echo " | ";
                                        echo $brand['no_polisi'];
                                        ?></option>
                                    <?php } else { ?>
                                      <option value="<?= $brand['id_mobil']; ?>">
                                        <?php echo $brand['nama'];
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
                                <label>Jenis Sewa</label>
                                <select name="jenis_sewa" class="form-control">
                                  <option value="Lepas Kunci" <?= ($row['jenis_sewa'] == 'Lepas Kunci') ? 'selected' : ''; ?>>Lepas Kunci</option>
                                  <option value="Paket Komplit" <?= ($row['jenis_sewa'] == 'Paket Komplit') ? 'selected' : ''; ?>>Paket Komplit</option>
                                </select>
                              </div>
                              <div class="form-group">
                                <label>Lama Sewa</label>
                                <select name="lama_sewa" class="form-control">
                                  <option value="<?= $row['lama_sewa']; ?>" selected><?= $row['lama_sewa'] ?></option>
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
                              <div class="form-group">
                                <label>Harga:</label>
                                <input type="number" class="form-control" name="harga" id="harga" value="<?= $row['harga']; ?>">
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

                  <!-- Modal Detail -->
                  <div id="modalDetail<?= $data['id_sewa']; ?>" class="modal fade" role="dialog">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">Detail Sewa</h4>
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">

                          <div class="form-group row">
                            <label for="nama" class="col-sm-3 col-form-label">Nama Pelanggan: </label>
                            <div class="col-sm-9">
                              <input type="text" readonly class="form-control-plaintext" id="nama" value="<?= $data['nama']; ?>">
                            </div>
                          </div>

                          <div class="form-group row">
                            <label for="nama" class="col-sm-3 col-form-label">Tanggal Sewa: </label>
                            <div class="col-sm-9">
                              <input type="text" readonly class="form-control-plaintext" id="nama" value="<?= date("d F Y", strtotime($data['tgl_sewa'])) ?>">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label for="nama" class="col-sm-3 col-form-label">Tanggal Kembali: </label>
                            <div class="col-sm-9">
                              <input type="text" readonly class="form-control-plaintext" id="nama" value="<?= date("d F Y", strtotime($endDate)) ?>">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label for="nama" class="col-sm-3 col-form-label">Lama Sewa: </label>
                            <div class="col-sm-9">
                              <input type="text" readonly class="form-control-plaintext" id="nama" value="<?= $data['lama_sewa'] > 23 ? $data['lama_sewa'] / 24 . ' Hari' : $data['lama_sewa'] . ' Jam' ?>">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label for="nama" class="col-sm-3 col-form-label">Mobil: </label>
                            <div class="col-sm-9">
                              <input type="text" readonly class="form-control-plaintext" id="nama" value="<?= $data['nama_mobil'] . ' | ' . $data['plat_mobil']  ?>">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label for="jenis_paket" class="col-sm-3 col-form-label">Paket: </label>
                            <div class="col-sm-9">
                              <input type="text" readonly class="form-control-plaintext" id="jenis_paket" value="<?= $data['jenis_sewa'] ?>">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label for="nama" class="col-sm-3 col-form-label">Harga: </label>
                            <div class="col-sm-9">
                              <input type="text" readonly class="form-control-plaintext" id="nama" value="<?= $data['harga'] ?>">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label for="nama" class="col-sm-3 col-form-label">Total Harga: </label>
                            <div class="col-sm-9">
                              <input type="text" readonly class="form-control-plaintext" id="nama" value="<?= $data['total_harga'] ?>">
                            </div>
                          </div>

                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Keluar</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Modal Konfirmasi -->
                  <div class="modal fade" id="myModalKonfirmasi<?= $data['id_sewa']; ?>" role="dialog">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">Konfirmasi sewa</h4>
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                          <form role="form" action="" method="POST">
                            <input type="hidden" name="id" value="<?= $data['id_sewa']; ?>">
                            <div class="form-group">
                              <h6>Apakah anda yakin ingin menyelesaikan data sewa ini?</h6>
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


                <?php
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <div id="myModalTambah" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Tambah Sewa</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form action="tambah-sewa-kendaraan.php" method="POST">
              <div class="modal-body">
                <div class="form-group">
                  <label>Nama Pelanggan:</label>
                  <select name="id_pelanggan" class="form-control">
                    <?php foreach ($customers as $customer) { ?>
                      <option value="<?= $customer['id_pelanggan']; ?>"><?= $customer['nama']; ?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="form-group">
                  <label>Mobil :</label>
                  <select name="id_mobil" class="form-control" id="id_mobil_daftar" onchange="getMobil(this.value)">
                    <option value="" disabled selected>pilih kendaraan...</option>
                    <?php
                    $query_mobil = mysqli_query($koneksi, "SELECT mobil.*, merek.merek FROM mobil JOIN merek ON mobil.id_merek=merek.id_merek ");
                    while ($brand = mysqli_fetch_array($query_mobil)) { ?>
                      <option value="<?= $brand['id_mobil']; ?>">
                        <?php echo $brand['nama'];
                        echo " | ";
                        echo $brand['no_polisi'];

                        ?>
                      </option>
                    <?php } ?>
                  </select>
                </div>

                <div id="id_mobil_hint"></div>
                <div id="id_paket_hint"></div>
                <div class="form-group">
                  <label>Tanggal Sewa:</label>
                  <input type="date" class="form-control" name="tgl_sewa">
                </div>
                <!-- <div class="form-group">
                  <label>Paket</label>
                  <select name="jenis_sewa" class="form-control">
                    <option value="Lepas Kunci">Lepas Kunci</option>
                    <option value="Paket Komplit">Paket Komplit</option>
                  </select>
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
                </div> -->
                <!-- <div class="form-group">
                  <label>Uang Muka (Down Payment):</label>
                  <input type="number" name="down_payment" class="form-control" id="down_payment" readonly>
                </div> -->
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
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

  <!-- Page level plugins -->
  <script src="vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script>
    $(document).ready(function() {
      $('#id_mobil').on('change', function() {
        var mobilId = $(this).val();
        updateHarga(mobilId);
      });

      function updateHarga(mobilId) {
        if (mobilId) {
          $.ajax({
            url: 'get_mobil_harga.php',
            type: 'POST',
            data: {
              id_mobil: mobilId
            },
            success: function(data) {
              $('#harga').val(data);
              calculateDownPayment();
            },
            error: function(xhr, status, error) {
              console.error('Error fetching price:', error);
            }
          });
        } else {
          $('#harga').val('');
          $('#down_payment').val('');
        }
      }

      function calculateDownPayment() {
        var harga = parseFloat($('#harga').val());
        if (!isNaN(harga)) {
          var downPayment = (harga * 30) / 100;
          $('#down_payment').val(downPayment);
        } else {
          $('#down_payment').val('');
        }
      }
    });
  </script>


  <!-- <script>
    function myFunction() {
      let x = document.getElementById("id_mobil_daftar").value;
      document.getElementById("demo").innerHTML = "You selected: " + x;
      document.getElementById("j_paket").value = x;
    }
  </script> -->

  <?php require 'footer.php'; ?>
</body>


</html>
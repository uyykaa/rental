<?php
$q = intval($_GET['q']);

$con = new mysqli("localhost", "root", "", "rental");
if (!$con) {
    die('Could not connect: ' . mysqli_error($con));
}

// mysqli_select_db($con, "rental");
// $sql = "SELECT * FROM users WHERE id = '" . $q . "'";
// $result = mysqli_query($con, $sql);


// while ($row = mysqli_fetch_array($result)) {
//     echo " <select name='user' class='form-control'>
//     <option value='1'>$row[nama]</option>
// </select>";
// }
// echo "
// </table>";


$sql = "SELECT * FROM harga WHERE id_mobil = '" . $q . "'";
$result = mysqli_query($con, $sql);
echo " 
<div class='form-group'>
<label>Paket</label>
<select name='jenis_sewa' class='form-control' id='jenis_sewa' onchange='getPaket(this.value, $q)'>";

echo "
        <option value='#' selected disabled>pilih jenis paket...</option>
    ";
while ($row = mysqli_fetch_array($result)) {
    echo "
            <option value='$row[jenis_paket]'>$row[jenis_paket]</option>
        ";
}
echo "</select>
    </div>";

mysqli_close($con);

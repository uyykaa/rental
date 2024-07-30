<?php
$q = strval($_GET['q']);
$id = intval($_GET['id']);

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


$sql = "SELECT * FROM harga WHERE jenis_paket = " . $q . " AND id_mobil = '" . $id . "'";
$result = mysqli_query($con, $sql);
echo " 
<div class='form-group'>
<label>Lama Sewa</label>
<select name='lama_sewa' class='form-control'>";

while ($row = mysqli_fetch_array($result)) {
    echo "<option value='$row[lama_sewa]'>";
    if ($row['lama_sewa'] <= 24) {
        echo " $row[lama_sewa] Jam | Harga Rp. $row[harga] | DP Rp.";
        echo ($row['harga'] / 2);
    } else {
        $days = ceil($row['lama_sewa'] / 24); // Convert hours to days, rounding up
        echo " $days Hari | Harga Rp. $row[harga] | DP Rp.";
        echo ($row['harga'] / 2);
    }
    echo "</option>";
}
echo "</select>
    </div>";

mysqli_close($con);
?>

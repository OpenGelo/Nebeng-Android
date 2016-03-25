<?php
include("koneksi.php");

date_default_timezone_set("Asia/Jakarta");

$timeStampSekarang = date('Y-m-d 07:00:00');
//$konversi = strtotime($timeStampSekarang. '+ 7 hours');
$timeSekarang = date('Y-m-d H:i:s');
$konversi_timeSekarang = strtotime($timeSekarang. '+ 7 hours');
$timeStampReset = strtotime($timeStampSekarang. '+ 1 day');

if ($konversi_timeSekarang === $timeStampReset){
$query_drop = mysql_query("DELETE FROM beri_tebengan");
echo "Data berhasil direset";
}
else{
echo "$konversi_timeSekarang\n";
echo "$timeStampReset\n";
echo "Belum saatnya reset database";}

?>
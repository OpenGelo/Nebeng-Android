<?php
include("koneksi.php");

//DateTime date_create_from_format ( string $format , string $time [, DateTimeZone $timezone ] )

$username = $_POST['username'];
$query_search = mysql_query("SELECT id FROM user WHERE username = '".$username."'");
$result = mysql_fetch_row($query_search);
$user_id = $result[0];

$asal = $_POST['asal'];
$tujuan = $_POST['tujuan'];
$kapasitas = $_POST['kapasitas'];
$jam_berangkat= $_POST['waktu_berangkat'];
$keterangan= $_POST['keterangan'];
$sisa_kapasitas = $_POST['kapasitas'];


$query_search2 = mysql_query("SELECT id_penebeng FROM nebeng WHERE id_penebeng = '".$user_id."'");
$query_search3 = mysql_query("SELECT user_id FROM beri_tebengan WHERE user_id = '".$user_id."'");
$extract_query_search2 = mysql_fetch_row($query_search2);
$extract_query_search3 = mysql_fetch_row($query_search3);
/*
$tanggal = strtotime("$waktu_berangkat");
$jam = strtotime("$jam_berangkat");
echo date("d-m-Y", $tanggal);
echo "\r\n";
echo time("H:i:s", $jam);
echo "\r\n";
echo "$tanggal";
echo "\r\n";
echo "$jam";
*/


$date_now = date("Y-m-d");
$jm = str_replace('.', '', $jam_berangkat);
$a = str_split($jm,2);
$b = $a[0] .':'. $a[1];
/*
$datetime = "$waktu_berangkat";
    $dt = str_replace(' ','',$datetime);
    $a = str_split($dt,2);
    $b = $a[2] .'-'. $a[1] .'-'. $a[0] .' '. $a[3] .':'. $a[4] .':'. $a[5];
//    echo date('Y-m-d H:i:s', strtotime($b));
echo "$b";
	*/
//$date = date_create_from_format('j-M-Y', '$waktu_berangkat');
//echo $date_format($date, 'd-m-Y');

//$tanggal_dmy = DateTime::createFromFormat('d-m-Y', '$waktu_berangkat')->format('Y-m-d');
//$waktu_his = DateTime::createFromFormat('H:i:s, '$jam_berangkat')->format('H:i:s');

//echo "$result[0]";
// check for empty result
 if ($extract_query_search2[0] !== NULL){
						echo "Maaf Anda sudah menebeng";	
						}
						
else if ($extract_query_search3[0] !== NULL){
						echo "Maaf Anda sudah memberi tebengan";	
						}	
else if ($result) {
        //$beri_tebengan = array();
$query_add = "INSERT INTO beri_tebengan (user_id, asal, tujuan, kapasitas, sisa_kapasitas, waktu_berangkat, jam_berangkat,keterangan) VALUES ('".$user_id."','".$asal."','".$tujuan."','".$kapasitas."', '".$sisa_kapasitas."', '".$date_now."', '".$b."', '".$keterangan."')";
$query_exec = mysql_query($query_add) or die(mysql_error());

	echo "Sukses";
} 

else {
	echo "Maaf Ada kesalahan";
    
}
?>
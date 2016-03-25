<?php
$hostname_localhost ="localhost";
$database_localhost ="iot";
$username_localhost ="root";
$password_localhost ="";
$localhost = mysql_connect($hostname_localhost,$username_localhost,$password_localhost)
or
trigger_error(mysql_error(),E_USER_ERROR);
 
mysql_select_db($database_localhost, $localhost);

//DateTime date_create_from_format ( string $format , string $time [, DateTimeZone $timezone ] )

$username = $_POST['username'];
$asal = $_POST['asal'];
$tujuan = $_POST['tujuan'];
$kapasitas = $_POST['kapasitas'];
$jam_berangkat= $_POST['waktu_berangkat'];
$keterangan= $_POST['keterangan'];

$query_search = mysql_query("SELECT id FROM user WHERE username = '".$username."'");
$result = mysql_fetch_row($query_search);


$date_now = date("Y-m-d");
$jm = str_replace('.', '', $jam_berangkat);
$a = str_split($jm,2);
$b = $a[0] .':'. $a[1];

if ($result) {
       
$query_add = "INSERT INTO beri_tebengan (user_id, asal, tujuan, kapasitas, sisa_kapasitas, waktu_berangkat, jam_berangkat, keterangan) VALUES 
('".$result[0]."','".$asal."','".$tujuan."','".$kapasitas."','".$kapasitas."','".$date_now."', '".$b."','".$keterangan."')";
$query_exec = mysql_query($query_add) or die(mysql_error());

if(!$query_exec) { 
	echo "Maaf Anda sudah memberikan tebengan";   }
 else  {
    
	echo "Data berhasil dimasukkan"; 
}

} else {
    
	echo "Data gagal dimasukkan";
}

?>
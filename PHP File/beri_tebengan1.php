<?php
$hostname_localhost ="localhost";
$database_localhost ="iot";
$username_localhost ="root";
$password_localhost ="";
$localhost = mysql_connect($hostname_localhost,$username_localhost,$password_localhost)
or
trigger_error(mysql_error(),E_USER_ERROR);
 
mysql_select_db($database_localhost, $localhost);
 
$response = array(); 
$username = $_POST['username'];
/*$asal = $_POST['asal'];
$tujuan = $_POST['tujuan'];
$kapasitas = $_POST['kapasitas'];
$waktu_berangkat = $_POST['waktu_berangkat'];
*/
$query_search = "SELECT id FROM user WHERE username = '".$username."'";
$result = mysql_query($query_search);


$query_add = "insert into beri_tebengan (npm,asal,tujuan,kapasitas,waktu_berangkat) values ('".$npm."','".$asal."','".$tujuan."','".$kapasitas."','".$waktu_berangkat."')";
$query_exec = mysql_query($query_add) or die(mysql_error());

 if(!$query_exec) { 
    echo "Data gagal dimasukkan";   }
 else  {
    
	echo "Data berhasil dimasukkan"; 
}
?>
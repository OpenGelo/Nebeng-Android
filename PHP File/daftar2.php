<?php
$hostname_localhost ="localhost";
$database_localhost ="iot";
$username_localhost ="root";
$password_localhost ="";
$localhost = mysql_connect($hostname_localhost,$username_localhost,$password_localhost)
or
trigger_error(mysql_error(),E_USER_ERROR);
 
mysql_select_db($database_localhost, $localhost);
 
 
$npm = $_POST['npm'];
$password = $_POST['password'];
$nama = $_POST['nama'];
    if (isset($_POST['laki'])){
        $jenis_kelamin = $_POST['laki'];        
}
if (isset($_POST['perempuan'])){
        $jenis_kelamin = $_POST['perempuan'];        
}
$alamat = $_POST['alamat'];
$email = $_POST['email'];
$kendaraan = $_POST['kendaraan'];
$no_hp = $_POST['no_hp'];
$no_telp = $_POST['no_telp'];
$query_add = "INSERT into user (npm, password, nama, jenis_kelamin, alamat, email, kendaraan, no_hp, no_telp) VALUES ('$npm', '$password', '$nama', '$jenis_kelamin','$alamat', '$email', '$kendaraan', '$no_hp', '$no_telp')";
$query_exec = mysql_query($query_add) or die(mysql_error());
//echo $rows;
 if(!$query_exec) { 
    echo "Data gagal dimasukkan";   }
 else  {
    
	echo "Data berhasil dimasukkan"; 
}
?>
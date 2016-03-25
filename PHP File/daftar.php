<?php
/*
$hostname_localhost ="localhost";
$database_localhost ="iot";
$username_localhost ="root";
$password_localhost ="";
$localhost = mysql_connect($hostname_localhost,$username_localhost,$password_localhost)
or
trigger_error(mysql_error(),E_USER_ERROR);
 
mysql_select_db($database_localhost, $localhost);
*/
include("koneksi.php");
 
$npm = $_POST['npm'];
$username = $_POST['username'];
$password = $_POST['password'];
$nama = $_POST['nama'];
$jenis_kelamin = $_POST['jenis_kelamin'];
$alamat = $_POST['alamat'];
$email = $_POST['email'];
$no_hp = $_POST['no_hp'];
$no_telp = $_POST['no_telp'];
$query_add = "insert into user (npm,username,password,nama,jenis_kelamin,alamat,email,no_hp,no_telp) values ('".$npm."','".$username."','".$password."','".$nama."','".$jenis_kelamin."','".$alamat."','".$email."','".$no_hp."','".$no_telp."')";
$query_exec = mysql_query($query_add) or die(mysql_error());
//echo $rows;
 if(!$query_exec) { 
    echo "Data gagal dimasukkan";   }
 else  {
    
	echo "Data berhasil dimasukkan"; 
}
?>
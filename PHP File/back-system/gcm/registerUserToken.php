<?php

/**
 * Program untuk menyimpan token GCM ke database Nebeng
 * 
 * @version 24 April 2016
 * @author I Made Sanadhi Sutandi // 1206202394
 */

//koneksi ke database
require_once("../db_connect.php");

//variabel post
$token 		= $_POST['token'];
$username	= $_POST['username'];

$response   	= array();  //variable respon

//melakukan update ke table nebeng_user
$query_update  = mysql_query("UPDATE nebeng_user SET gcm_token = '$token' WHERE username = '$username'") or die(mysql_error());

	if ($query_update){ //jika update berhasil
		$response["result"] = "Registrasi token berhasil";
	}

	else { //jika gagal
		$response["result"] = "Registrasi token gagal";
	} 

//tampilkan respon dalam array json
echo json_encode($response);
?>
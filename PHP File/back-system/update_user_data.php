<?php

/**
 * Program Update no handphone, email 
 * Mengupdate table nebeng_user
 * Param yang diterima adalah username, nomor, dan email dari POST
 * 
 * @version 29 Maret 2016
 * @author I Made Sanadhi Sutandi // 1206202394
 */

//koneksi ke database
require_once("db_connect.php");

//variabel post
$username 		= $_POST['username'];
$no_handphone 	= $_POST['nomor'];
$email 			= $_POST['email'];

$response   	= array();  //variable respon

//melakukan update ke table nebeng_user
$query_update  = mysql_query("UPDATE nebeng_user SET no_handphone = '$no_handphone', email = '$email' WHERE username = '$username'") or die(mysql_error());

	if ($query_update){ //jika update berhasil
		$response["result"] = "Sukses";
	}

	else { //jika gagal
		$response["result"] = "Maaf Ada kesalahan";
	} 

//tampilkan respon dalam array json
echo json_encode($response);
?>
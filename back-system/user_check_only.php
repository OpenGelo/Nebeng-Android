<?php

/**
 * Check User
 * Mengecek apakah pengguna terdaftar di database nebeng atau tidak
 * 
 * @version 26 Maret 2016
 * @author I Made Sanadhi Sutandi // 1206202394
 */

require_once("db_connect.php");

$username 		= $_POST['username']; //username dari pengguna
$response 		= array();			  //variable respon

$query_check 		 = mysql_query("SELECT username FROM nebeng_user USER WHERE username = '$username'"); //cek pengguna
$extract_query_check = mysql_fetch_row($query_check);

if($extract_query_check){	//apabila terdapat, nilai true
	$response["result"] = "User Found";
}
else{						//jika tidak terdapat, maka nilai false
	$response["result"] = "User Not Found";
}

//tampilkan respon dalam array json
echo json_encode($response);
?>
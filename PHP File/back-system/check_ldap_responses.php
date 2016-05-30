<?php
/**
 * Pengecekan LDAP
 * Melakukan cetak respon dari server LDAP UI
 * 
 * @version 24 April 2016
 * @author I Made Sanadhi Sutandi // 1206202394
 */

require_once("db_connect.php");	//load pengaturan autentikasi dan hubungan ke database
require_once("ldap.php");		//load modul autentikasi SSO ke ldap UI

	//inisialisasi variabel
	$user 		= trim($_POST['username']);
	$password 	= $_POST['password'];
	$response 	= array();					//variable respon

	if(empty($user) && empty($password)){								//pengecekan kosong atau tidaknya input nama dan password pengguna
		$response["result"] = "Masukkan Username dan Password Anda";
	}
	elseif(empty($password)){											//pengecekan kosong atau tidaknya password pengguna
		$response["result"] = "Masukkan Password Anda";
	}
	elseif(empty($user)){												//pengecekan kosong atau tidaknya username pengguna
		$response["result"] = "Masukkan Username Anda";	
	}	
	else
	{				
		$user_data			= ldap_auth($user,$password);
		$response["result"]	= $user_data;	//rekam respon dari LDAP
	}

//tampilkan respon dalam array json
echo json_encode($response);
?>
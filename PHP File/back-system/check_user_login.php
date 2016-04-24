<?php
/**
 * Program Check-login, mengecek apakah user sudah terdaftar atau belum ketika login aplikasi
 * Mengecek apakah pengguna terdaftar atau tidak di LDAP UI
 * Mendaftarkan credentials pengguna dari LDAP UI ke serveng nebeng
 * 
 * @version 24 April 2016
 * @author I Made Sanadhi Sutandi // 1206202394
 */

require_once("db_connect.php");	//load pengaturan autentikasi dan hubungan ke database
require_once("ldap.php");		//load modul autentikasi SSO ke ldap UI

	//inisialisasi variabel
	$username	= trim($_POST['username']);
	$password 	= $_POST['password'];
	$response 	= array();					//variable respon

	if(empty($username) && empty($password)){								//pengecekan kosong atau tidaknya input nama dan password pengguna
		$response["result"] = "Masukkan Username dan Password Anda";
	}
	elseif(empty($password)){											//pengecekan kosong atau tidaknya password pengguna
		$response["result"] = "Masukkan Password Anda";
	}
	elseif(empty($username)){												//pengecekan kosong atau tidaknya username pengguna
		$response["result"] = "Masukkan Username Anda";	
	}	
	else //jika input sudah benar
	{			
		$user_data=ldap_auth($username,$password);	//autentikasi ke LDAP UI dan ambil data return berupa informasi pengguna

		//respons di-init
			$response['id'] 		= "";
			$response['npm']		= "";
			$response['username']	= "";


		if(!empty($user_data)){
			$userid		=$user_data[0];			//user id, contoh maryam.nurhadi
			$npm		=$user_data[1];			//npm, contoh 1206202394
			$role		=$user_data[2];			//role, contohnya mahasiswa
			$nama_user	=$user_data[3];			//nama lengkap contohnya "Muhammad Adika"
			$email		=$user_data[4];			//email, contohnya sanadhi.sutandi@ui.ac.id
			//$kodeorg	=$user_data[5];			//kode mahasiswa beserta jurusan dan fakultas, contoh xx.xx.02.03.04.01:mahasiswa

			$query_search 	= "select * from nebeng_user where username='$userid'";		//query pengecekan 
			$query_exec 	= mysql_query($query_search) or die(mysql_error());				//check pengguna
			$rows 			= mysql_num_rows($query_exec);

			if(!empty($rows)) { 	//jika pengguna sudah terdaftar
				$response["result"] = "User Found";
											 
			}

			else{					//lainnya, daftarkan pengguna jika pengguna ybs belum terdaftar
				$query_add  		= "insert into nebeng_user 
							 			(nama,npm,username,role,email) values 
							 			('$nama_user','$npm','$username','$role','$email')
							 		  ";
				$query_exec 		= mysql_query($query_add) or die(mysql_error());
				$response["result"] = "User New";
			}

			//mengambil user id
			$query_search 	= mysql_query("SELECT id FROM nebeng_user WHERE username = '$username'");
			$result 		= mysql_fetch_row($query_search);
			$id 			= $result[0];
			$response['id'] 		= $id;
			$response['npm']		= $npm;
			$response['username']	= $userid;
			$response['role']		= $role;
			$response['nama']		= $nama_user;				
		}

		else{	//jika user dengan username dan password tidak ditemukan di server LDAP		
			$response["result"] = "No Such User Found";			
		}	
}

//tampilkan respon dalam array json
echo json_encode($response);
?>
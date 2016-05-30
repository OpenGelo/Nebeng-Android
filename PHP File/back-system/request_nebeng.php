<?php

/**
 * Program untuk melakukan tebengan ke daftar tebengan yang tersedia
 * Param username, id_tebengan, dan update melalui POST
 * 
 * @version 30 Mei 2016
 * @author I Made Sanadhi Sutandi // 1206202394
 */

require_once("db_connect.php");

//variable post
$username 		= $_POST['username'];
$id_tebengan 	= $_POST['id_tebengan'];
$id_penebeng	= $_POST['id_pengguna'];
$update 		= $_POST['update'];

//untuk mencatat waktu nebeng
date_default_timezone_set("Asia/Jakarta");
$time 			= date('Y-m-d H:i:s');

$response 		= array();					//variable respon

	if($update=='nebeng'){ //kode untuk request nebeng

		//cek apakah tebengan dengan id tebengan yang diajukan tersedia di database
		$query_cek_tebengan	= mysql_query("SELECT id_tebengan FROM nebeng_beri_tebengan WHERE id_tebengan = '$id_tebengan'") or die(mysql_error());
		$values 			= mysql_fetch_row($query_cek_tebengan);

		if ($values[0] == NULL){ //jika id tebengan yang dituju tidak terdapat di tabel
			$response["result"] = "Maaf id ini tidak terdapat di database"; 
		}
		else{  //jika id tebengan terdapat di database
			
			//cek sisa kapasitas dari tebengan tersebut
			$query_cek_kapasitas	= mysql_query("SELECT sisa_kapasitas FROM nebeng_beri_tebengan WHERE id_tebengan = '$id_tebengan'") or die(mysql_error());
			$values 				= mysql_fetch_row($query_cek_kapasitas);
			
			if ($values[0] == '0'){ //jika kapasitas nya nol
				$response["result"] = "Maaf kapasitas tidak cukup"; 
			}
			
			else{ //jika kapasitas cukup

				$query_cek1		= mysql_query("SELECT user_id FROM nebeng_beri_tebengan WHERE user_id = '$id_penebeng' and detail_waktu_kadaluarsa >= '$time'") or die(mysql_error());		//cek apakah si penebeng merupakan pemberi tebengan atau tidak
				$query_cek2		= mysql_query("SELECT nebeng_nebeng.id_penebeng FROM nebeng_nebeng INNER JOIN nebeng_beri_tebengan on 
												nebeng_nebeng.id_tebengan = nebeng_beri_tebengan.id_tebengan WHERE nebeng_nebeng.id_penebeng = '$id_penebeng' and nebeng_beri_tebengan.detail_waktu_kadaluarsa >= '$time'") or die(mysql_error());	//cek apakah si penebeng sudah menebeng sebelumnya
				$result_cek1	= mysql_fetch_row($query_cek1);

				$result_cek2 	= mysql_fetch_row($query_cek2);


				if($result_cek1[0] != NULL){ //apabila si penebeng merupakan pemberi tebeng
					$response["result"] = "Tolong cek status Anda terlebih dahulu";
				}
				else if($result_cek2[0] != NULL){ //apabila si penebeng sudah menebeng sebelumnya
					$response["result"] = "Tolong cek status Anda terlebih dahulu";
				}
				else{ //jika status calon penebeng sudah dipastikan
					$query_pengurangan_kapasitas 	= mysql_query("UPDATE nebeng_beri_tebengan SET sisa_kapasitas = sisa_kapasitas-1 WHERE id_tebengan = '$id_tebengan'") or die(mysql_error());
					$query_write_nebeng		 		= mysql_query("INSERT INTO nebeng_nebeng VALUES ('$id_penebeng', '$id_tebengan', '$time')") or die(mysql_error());
					if($query_pengurangan_kapasitas && $query_write_nebeng){
						$response["result"] = "Nebeng Sukses";
					}
				}
				
			}
		}
	}

	else{ //untuk request tanpa kode update yang ditentukan
		$response["result"] = "Maaf ada kesalahan";
	}	

//tampilkan respon dalam array json
echo json_encode($response);
?>
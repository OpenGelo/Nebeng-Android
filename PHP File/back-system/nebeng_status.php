<?php

/**
 * Program untuk mengecek kondisi menebeng/tebengan dari seorang pengguna
 * Untuk penebeng, akan mengembalikan informasi dari si pemberi tebengan
 * Untuk pemberi tebengan, akan mengembalikan informasi para penebeng
 * Param username dan user_id dari POST
 * 
 * @version 04 April 2016
 * @author I Made Sanadhi Sutandi // 1206202394
 */

require_once("db_connect.php");

$response   = array();  //variable respon

//variable post
$username 		= $_POST['username'];

//mengambil user id
$query_search 	= mysql_query("SELECT id FROM nebeng_user WHERE username = '$username'");
$result 		= mysql_fetch_row($query_search);
$id 			= $result[0];

//mengecek apakah user sedang memberikan tebengan atau tidak
$query_search 	= mysql_query("SELECT user_id FROM nebeng_beri_tebengan WHERE user_id = '$id'") or die(mysql_error());
$result 		= mysql_fetch_row($query_search);

if ($result[0]>'0') { //jika user bersangkutan memberi tebengan

	//mengambil id dari seluruh penebeng untuk tebengan tersebut
	$query_search 	= mysql_query("SELECT id_penebeng FROM nebeng_nebeng WHERE id_tebengan = '$id'") or die(mysql_error());
	$result 		= mysql_fetch_row($query_search);

	if($result[0] > '0'){	//jika terdapat penebeng untuk tebengan tersebut

		while ($row = mysql_fetch_array($query_search)) { //per iterasi mengambil data penebeng

			$response["hasil"] 	= array();
			//query untuk mengambil data pengguna
			$hasil 				= mysql_query("SELECT npm, nama, no_handphone, email FROM nebeng_user WHERE id = '".$row["id_penebeng"]."'") or die(mysql_error()); 

			while($rowi = mysql_fetch_array($hasil)){ //ambil data penebeng
				
				$nebeng 			= array();
				$nebeng["npm"] 		= $rowi["npm"];
				$nebeng["nama"] 	= $rowi["nama"];
				$nebeng["no_hp"] 	= $rowi["no_handphone"];
				$nebeng["email"] 	= $rowi["email"];
				$nebeng["status"] 	= 'Nebengin';
				array_push($response["hasil"], $nebeng);
			}
		}
		$response["success"] = 1;
	}
	else
	{	//jika tidak terdapat penebeng untuk tebengan tersebut
		$response["hasil"] 	= array();
		$nebeng 			= array();
		$nebeng["npm"] 		= 'Belum ada';
		$nebeng["nama"] 	= 'Belum ada';
		$nebeng["no_hp"] 	= 'Tidak ada';
		$nebeng["email"] 	= 'Tidak ada';
		$nebeng["status"] 	= 'Sedang memberikan Tebengan';
		array_push($response["hasil"], $nebeng);
		$response["success"] = 1;
	}
}
else
{	//jika user tidak sedang memberikan tebengan

	//cek apakah user menebeng atau tidak
	$query_search 	= mysql_query("SELECT id_penebeng FROM nebeng_nebeng WHERE id_penebeng = '$id'") or die(mysql_error());
	$result 		= mysql_fetch_row($query_search);

	if ($result[0]>'0') { //jika user bersangkutan sedang menebeng

		//mengambil id pemberi tebengan
		$query_search 	= mysql_query("SELECT id_tebengan FROM nebeng_nebeng WHERE id_penebeng = '$id'") or die(mysql_error()); 

		while ($row = mysql_fetch_array($query_search)) { 

			$response["hasil"] 	= array();
			//mengambil identitas dari si pemberi tebengan
			$hasil 				= mysql_query("SELECT npm, nama, no_handphone, email FROM nebeng_user WHERE id = '".$row["id_tebengan"]."'") or die(mysql_error()); 

			while($rowi = mysql_fetch_array($hasil)){
				
				$nebeng 			= array();
				$nebeng["npm"] 		= $rowi["npm"];
				$nebeng["nama"] 	= $rowi["nama"];
				$nebeng["no_hp"] 	= $rowi["no_handphone"];
				$nebeng["email"] 	= $rowi["email"];
				$nebeng["status"] 	= 'Nebeng';
				array_push($response["hasil"], $nebeng);
			}
			
		}
		$response["success"] = 1;
		
	}
	else{	//jika user tidak sedang menebeng

		$response["hasil"] 	= array();
		$nebeng 			= array();
		$nebeng["npm"] 		= 'Tidak ada';
		$nebeng["nama"] 	= 'Tidak ada';
		$nebeng["no_hp"] 	= 'Tidak ada';
		$nebeng["email"] 	= 'Tidak ada';
		$nebeng["status"] 	= 'Bebas';
		
		array_push($response["hasil"], $nebeng);
	}
}

//tampilkan respon dalam array json
echo json_encode($response);
?>
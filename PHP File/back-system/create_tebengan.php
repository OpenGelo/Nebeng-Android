<?php

/**
 * Endpoint membuat tebengan
 * 
 * @version 25 Mei 2016
 * @author I Made Sanadhi Sutandi // 1206202394
 */

require_once("db_connect.php");

$response 			= array();			  //variable respon

//ambil variabel post
$username 		= $_POST['username'];
$asal 			= $_POST['asal'];
$tujuan 		= $_POST['tujuan'];
$kapasitas 		= $_POST['kapasitas'];
$jam_berangkat	= $_POST['waktu_berangkat'];
$keterangan		= $_POST['keterangan'];

//olah data waktu untuk insert ke database
date_default_timezone_set("Asia/Jakarta");
$date_now 			= date("Y-m-d");
$jam_berangkat 		= str_replace('.', ':', $jam_berangkat); //beda format waktu 23.59 -> 23:59
$jam_kadaluarsa 	= new DateTime($jam_berangkat);
$jam_kadaluarsa->modify('+1 hour'); 		//set jam kadaluarsa = +1 jam dari waktu yang disediakan
$jam_kadaluarsa  	= $jam_kadaluarsa->format('H:i'); //jam kadaluarsa

/*Untuk mengecek expiry dari tebengan terakhir!*/
$date_expired         = date_create(date('Y-m-d'));
$dateExpiredToString  = $date_expired->format('Y-m-d');
$time_expired         = date_create(date('H:i:s'));
$timeExpiredToString  = $time_expired->format('H:i:s');

//waktu saat ini
$nowDate = date('Y-m-d H:i:s');

$date_expired       = date(('Y-m-d '.$jam_berangkat), strtotime('+1 hours'));

$date_expired       = new DateTime($date_expired);
$date_expired       ->modify('+1 hour');         //set jam kadaluarsa = +1 jam dari waktu yang disediakan
$date_expired       = $date_expired->format('Y-m-d H:i:s'); //jam kadaluarsa

//ambil user_id = id user dari tabel user
$query_search 	= mysql_query("SELECT id FROM nebeng_user WHERE username = '$username'") or die(mysql_error());
$result 		= mysql_fetch_row($query_search);
$user_id 		= $result[0];

//cek apakah pengguna yang hendak memberi tumpangan merupakan penebeng atau sudah memberi tumpangan sebelumnya
$query_search2 			= mysql_query("SELECT nebeng_nebeng.id_penebeng FROM nebeng_nebeng INNER JOIN nebeng_beri_tebengan 
							on nebeng_nebeng.id_tebengan = nebeng_beri_tebengan.id_tebengan 
							WHERE nebeng_nebeng.id_penebeng = '$user_id' and nebeng_beri_tebengan.detail_waktu_kadaluarsa >= '$nowDate'") or die(mysql_error());
$query_search3 			= mysql_query("SELECT id_tebengan FROM nebeng_beri_tebengan WHERE user_id = '$user_id' AND detail_waktu_kadaluarsa >= '$nowDate'") or die(mysql_error());
$extract_query_search2 	= mysql_fetch_row($query_search2);
$extract_query_search3 	= mysql_fetch_row($query_search3);

	if ($extract_query_search2[0] != NULL){ //check apakah id tersebut menebeng atau tidak
		$response["result"] = "Maaf Anda sudah menebeng";
	}
	else if ($extract_query_search3[0] != NULL){	//check apakah id tersebut sudah memberi tebengan atau tidak
		$response["result"] = "Maaf Anda sudah memberi tebengan";	
	}	
	else if ($result) {		//insert data nebeng ke database
		$query_add 	= "INSERT INTO nebeng_beri_tebengan (user_id, asal, tujuan, kapasitas, sisa_kapasitas, waktu_berangkat, jam_berangkat, jam_kadaluarsa, keterangan, detail_waktu_kadaluarsa) 
						VALUES ('$user_id','$asal','$tujuan','$kapasitas', '$kapasitas', '$date_now', '$jam_berangkat', '$jam_kadaluarsa','$keterangan', '$date_expired')";
		$query_exec = mysql_query($query_add) or die(mysql_error());
		$response["result"] = "Sukses";
	} 
	else {
		$response["result"] = "Maaf Ada kesalahan";	
	}
//tampilkan respon dalam array json
echo json_encode($response);
?>
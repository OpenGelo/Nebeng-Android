<?php

/**
 * Program untuk melakukan pembatalan tebengan dan batal menebeng
 * Bagi penebeng membatalkan hendak menebeng
 * Bagi pemberi tebengan membatalkan tebengannya
 * Param username, update, dan user_id melalui POST
 * Mengirimkan pesan push sebagai respon perintah
 * Jika menghapus tumpangan, broadcast ke seluruh penumpang
 * Jika membatalkan tumpangan, unicast ke pemberi tumpangan
 * 
 * @version 07 Juni 2016
 * @author I Made Sanadhi Sutandi // 1206202394
 */

require_once("db_connect.php");
require_once("gcm/module.php");

//variable post
$username 	 = $_POST['username'];
$update 	 = $_POST['update'];

//waktu saat ini
date_default_timezone_set("Asia/Jakarta");
$nowDate = date('Y-m-d H:i:s');

//ambil id pemberi tebengan yang hendak menghapus tebengannya
$query_search 	= mysql_query("SELECT id FROM nebeng_user WHERE username = '$username'") or die(mysql_error());
$result 		= mysql_fetch_row($query_search);
$user_id 		= $result[0];

if($update=='reset'){ //request untuk reset tebengan

	//mengecek apakah tebengan berdasar id user tersebut tersedia atau tidak
	$query_check	= mysql_query("SELECT id_tebengan FROM nebeng_beri_tebengan WHERE user_id = '$user_id' and detail_waktu_kadaluarsa>= '$nowDate'") or die(mysql_error());
	$check_result 	= mysql_fetch_row($query_check);
	$id_tebengan	= $check_result[0];

	if($id_tebengan != NULL){ //apabila terdapat tebengan dari id user tersebut
		
		//get nama pemberi tumpangan
		$query_nama 		= mysql_query("Select nama from nebeng_user where username = '$username'") or die(mysql_error());
		$result 			= mysql_fetch_row($query_nama);
		$nama				= $result[0];

		$allPenumpang = mysql_query("Select id_penebeng from nebeng_nebeng") or die(mysql_error());

		while($row = mysql_fetch_array($allPenumpang)){
			//kirim push ke id tujuan
			sendPushById($row["id_penebeng"],"$nama membatalkan tumpangan yang diberikan");
		}

		$result = mysql_query("Delete from nebeng_nebeng WHERE id_tebengan = '$id_tebengan'") or die(mysql_error());	//hapus record tebengan yang terjadi
		$result = mysql_query("Delete from nebeng_beri_tebengan WHERE id_tebengan = '$id_tebengan'") or die(mysql_error());	//hapus record ketersediaan tebengan
		$response["result"] = "Postingan nebeng berhasil dihapus";
	}
	else{ //apabila user tersebut ternyata tidak memberi tebengan
		$response["result"] = "anda tidak sedang memberi tebengan";
		sendPush($username,"Anda tidak sedang memberi tumpangan!");
	}
}

else if ($update=='batal') { //request untuk cancel menebeng

	$query_search 	= mysql_query("SELECT id_tebengan FROM nebeng_nebeng WHERE id_penebeng='$user_id'") or die(mysql_error());
	$values 		= mysql_fetch_row($query_search);
	$id_tebengan	= $values[0];
	
	if ($id_tebengan != NULL)
	{
		$query_delete 		= mysql_query("Delete from nebeng_nebeng WHERE id_penebeng = '$user_id'") or die(mysql_error());
		$query_update 		= mysql_query("Update nebeng_beri_tebengan set sisa_kapasitas=sisa_kapasitas+1 where id_tebengan = '$id_tebengan'") or die(mysql_error());
		$response["result"] = "Tebengan berhasil dibatalkan";

		//get id pemberi tumpangan
		$query_user 		= mysql_query("Select user_id from nebeng_beri_tebengan where id_tebengan = '$id_tebengan'") or die(mysql_error());
		$result 			= mysql_fetch_row($query_user);
		$idTujuan			= $result[0];

		//get nama penumpang
		$query_nama 		= mysql_query("Select nama from nebeng_user where username = '$username'") or die(mysql_error());
		$result 			= mysql_fetch_row($query_nama);
		$nama				= $result[0];

		//kirim push ke id tujuan
		sendPushById($idTujuan,"$nama membatalkan permintaan menumpang ke anda");
	}
	else 
	{
		$response["result"] = "Anda tidak sedang menebeng";
		sendPush($username,"Anda tidak sedang menumpang!");
	}
}	
else{
	$response["result"] = "Maaf ada kesalahan";
	sendPush($username,"Maaf, permintaan anda gagal!");
}	

//tampilkan respon dalam array json
echo json_encode($response);
?>
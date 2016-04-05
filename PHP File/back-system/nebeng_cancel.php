<?php

/**
 * Program untuk melakukan pembatalan tebengan dan batal menebeng
 * Bagi penebeng membatalkan hendak menebeng
 * Bagi pemberi tebengan membatalkan tebengannya
 * Param username, update, dan user_id melalui POST
 * 
 * @version 29 Maret 2016
 * @author I Made Sanadhi Sutandi // 1206202394
 */

require_once("db_connect.php");

//variable post
$username 	 = $_POST['username'];
$update 	 = $_POST['update'];
$id_penebeng = $_POST['user_id'];

//ambil id pemberi tebengan yang hendak menghapus tebengannya
$query_search 	= mysql_query("SELECT id FROM nebeng_user WHERE username = '$username'") or die(mysql_error());
$result 		= mysql_fetch_row($query_search);
$id_penebeng 	= $result[0];

//untuk mencatat waktu nebeng
$time = gmdate("H:i:s", time()+60*60*7);

if($update=='reset'){ //request untuk reset tebengan

	//mengecek apakah tebengan berdasar id user tersebut tersedia atau tidak
	$query_check	= mysql_query("SELECT user_id FROM nebeng_beri_tebengan WHERE user_id = '$user_id'") or die(mysql_error());
	$check_result 	= mysql_fetch_row($query_check);

	if($check_result[0] != NULL){ //apabila terdapat tebengan dari id user tersebut
		$result = mysql_query("Delete from nebeng_nebeng WHERE id_tebengan = '$user_id'") or die(mysql_error());	//hapus record tebengan yang terjadi
		$result = mysql_query("Delete from nebeng_beri_tebengan WHERE user_id = '$user_id'") or die(mysql_error());	//hapus record ketersediaan tebengan
		echo "Postingan nebeng berhasil dihapus";
	}
	else{ //apabila user tersebut ternyata tidak memberi tebengan
		echo "anda tidak sedang memberi tebengan";
	}
}

else if ($update=='batal') { //request untuk cancel menebeng

	$query_search 	= mysql_query("SELECT id_tebengan FROM nebeng_nebeng WHERE id_penebeng='$user_id'") or die(mysql_error());
	$values 		= mysql_fetch_row($query_search);
	$id_tebengan	= $values[0];
	
	if ($id_tebengan != '0')
	{
		$query_sisa_kapasitas = mysql_query("SELECT sisa_kapasitas FROM nebeng_beri_tebengan WHERE user_id = '$id_tebengan'") or die(mysql_error());
		$query_kapasitas= mysql_query("SELECT kapasitas FROM nebeng_beri_tebengan WHERE user_id = '$id_tebengan'") or die(mysql_error());
		$values = mysql_fetch_row($query_sisa_kapasitas);
		$values1 = mysql_fetch_row($query_kapasitas);
		if ($values[0] == $values1[0]){
			echo "Maaf, Anda tidak dapat membatalkan tebengan ini";
		}
		else{
			$result = mysql_query("UPDATE nebeng_beri_tebengan SET sisa_kapasitas=sisa_kapasitas+1 WHERE user_id = '$id_tebengan'") or die(mysql_error());
			$result = mysql_query("Delete from nebeng_nebeng WHERE id_penebeng = '$user_id'") or die(mysql_error());
			echo "Tebengan berhasil dibatalkan";
		}
	}
	else 
	{
		echo "anda tidak sedang menebeng";
	}
}	
else{
	echo "Maaf ada kesalahan";
}	

?>
<?php
require_once("koneksi.php");
 
// array for JSON response

 
// connecting to db
//$db = new DB_CONNECT();
//$npm = $_POST['npm'];
$username = $_POST['username'];
$query_search = mysql_query("SELECT id FROM nebeng_user WHERE username = '".$username."'");
$result = mysql_fetch_row($query_search);
$user_id = $result[0];
$id_penebeng = $user_id;

$id_tebengan = $_POST['id_tebengan'];
$update = $_POST['update'];
//$update1 = $_POST['update'];
//$update2 = $_POST['update'];
$time = gmdate("H:i:s", time()+60*60*7);
//echo $update;
//echo $update1;
//echo $update2;

if($update=='nebeng'){
	$extract_result=mysql_query("SELECT user_id FROM nebeng_beri_tebengan WHERE user_id = '".$id_tebengan."'");
	$values = mysql_fetch_row($extract_result);
	if ($values[0] == NULL){
				echo "Maaf id ini tidak membuka tebengan"; 
		}
	else{
	$extract_result=mysql_query("SELECT sisa_kapasitas FROM nebeng_beri_tebengan WHERE user_id = '".$id_tebengan."'");
	$values = mysql_fetch_row($extract_result);
	//(int)$values;
	//var_dump($values);
		//$query_sisa_kapasitas = mysql_query("SELECT sisa_kapasitas FROM beri_tebengan WHERE id_tebengan = '".$id_tebengan."'");
			
			if ($values[0] == '0'){
				echo "Maaf kapasitas tidak cukup"; 
				}
				
			else{
				$cek = mysql_query("SELECT user_id FROM nebeng_beri_tebengan WHERE user_id = '".$user_id."'");
				$cek1= mysql_query("SELECT id_penebeng FROM nebeng_nebeng WHERE id_penebeng = '".$user_id."'");
				$cek_cek = mysql_fetch_row($cek);
				$cek_cek1 = mysql_fetch_row($cek1);
					if($cek_cek[0] !== NULL){
						//echo $cek2;
						echo "Tolong cek status Anda terlebih dahulu";
											}
					else if($cek_cek1[0] !== NULL){
						echo "Tolong cek status Anda terlebih dahulu";
												  }
					else{
						$kapasitas_dikurangi = mysql_query("UPDATE nebeng_beri_tebengan SET sisa_kapasitas = sisa_kapasitas-1 WHERE user_id = '".$id_tebengan."'");
						$write_to_nebeng = mysql_query("INSERT INTO nebeng_nebeng VALUES ('".$id_penebeng."', '".$id_tebengan."', '".$time."')");
						//$values = mysql_fetch_row($kapasitas_dikurangi);
						//var_dump($values);
						echo "Nebeng Sukses";
						}
				
				}
	}
}

/*else if($update1=='konfirmasi'){
	$extract_result=mysql_query("SELECT sisa_kapasitas FROM beri_tebengan WHERE id_tebengan = '".$id_tebengan."'");
	$values = mysql_fetch_row($extract_result);
	//(int)$values;
	//var_dump($values);
			if ($values[0] == '0'){
				echo "";
				}
				
			else{
				$konfirmasi = mysql_query("UPDATE nebeng SET waktu_konfirmasi = '".$time."' WHERE id_tebengan = '".$id_tebengan."'");
				//$values = mysql_fetch_row($kapasitas_dikurangi);
				//var_dump($values);
				echo "Konfirmasi berhasil";
				}
}
else if ($update2=='batal') {
	$query_sisa_kapasitas = mysql_query("SELECT sisa_kapasitas FROM beri_tebengan WHERE id_tebengan = '".$id_tebengan."'");
	$query_kapasitas= mysql_query("SELECT kapasitas FROM beri_tebengan WHERE id_tebengan = '".$id_tebengan."'");
	$values = mysql_fetch_row($query_sisa_kapasitas);
	$values1 = mysql_fetch_row($query_kapasitas);
	//(int)$values;
	//var_dump($values);
	//var_dump($values1);
	//$query_sisa_kapasitas = mysql_query("SELECT sisa_kapasitas FROM beri_tebengan WHERE id_tebengan = '".$id_tebengan."'");
	//$query_kapasitas= mysql_query("SELECT kapasitas FROM beri_tebengan WHERE id_tebengan = '".$id_tebengan."'");
		if ($values[0] == $values1[0]){
			echo "Maaf, Anda tidak dapat membatalkan tebengan ini";
			}
		else{
			$result = mysql_query("UPDATE beri_tebengan SET sisa_kapasitas=sisa_kapasitas+1 WHERE id_tebengan = '".$id_tebengan."'");
			echo "Tebengan berhasil dibatalkan";
			}
}*/
else{
	echo "Maaf ada kesalahan";
	}	
// check for empty result
/*CREATE VIEW perhitungan_kapasitas AS
SELECT id_tebengan, kapasitas AS sisa_kapasitas
FROM beri_tebengan
*/
?>
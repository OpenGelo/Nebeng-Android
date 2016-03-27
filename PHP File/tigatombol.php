<?php
require_once("koneksi.php");

// array for JSON response

$username = $_POST['username'];
$query_search = mysql_query("SELECT id FROM nebeng_user WHERE username = '".$username."'");
$result = mysql_fetch_row($query_search);
$user_id = $result[0];
$id_penebeng = $user_id;

$id_tebengan = $_POST['id_tebengan'];
$update = $_POST['update'];
$time = gmdate("H:i:s", time()+60*60*7);

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

else{
	echo "Maaf ada kesalahan";
}	

?>
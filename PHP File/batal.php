<?php
require_once("koneksi.php");

$username = $_POST['username'];
$query_search = mysql_query("SELECT id FROM nebeng_user WHERE username = '".$username."'");
$result = mysql_fetch_row($query_search);
$user_id = $result[0];
$id_penebeng = $user_id;

$update = $_POST['update'];
$update2 = $_POST['update'];
$time = gmdate("H:i:s", time()+60*60*7);

if($update=='reset'){
	$cek = mysql_query("SELECT user_id FROM nebeng_beri_tebengan WHERE user_id = '".$user_id."'");
	$cek_cek = mysql_fetch_row($cek);
	if($cek_cek[0] !== NULL){
			//echo $cek2;
			$result = mysql_query("Delete from nebeng_nebeng WHERE id_tebengan = '".$user_id."'");
			$result = mysql_query("Delete from nebeng_beri_tebengan WHERE user_id = '".$user_id."'");
				echo "Postingan nebeng berhasil dihapus";
		}
	else{
			echo"anda tidak sedang memberi tebengan";
		}
	
}

else if ($update2=='batal') {
	$query_search = mysql_query("SELECT id_tebengan FROM nebeng_nebeng WHERE id_penebeng='".$user_id."'");
	$values = mysql_fetch_row($query_search);
	$id_tebengan=$values[0];
	if ($id_tebengan != '0')
	{
		// $query_sisa_kapasitas = mysql_query("SELECT sisa_kapasitas FROM nebeng_beri_tebengan WHERE id_tebengan = '".$id_tebengan."'");
		$query_sisa_kapasitas = mysql_query("SELECT sisa_kapasitas FROM nebeng_beri_tebengan WHERE user_id = '".$id_tebengan."'");
		// $query_kapasitas= mysql_query("SELECT kapasitas FROM nebeng_beri_tebengan WHERE id_tebengan = '".$id_tebengan."'");
		$query_kapasitas= mysql_query("SELECT kapasitas FROM nebeng_beri_tebengan WHERE user_id = '".$id_tebengan."'");
		$values = mysql_fetch_row($query_sisa_kapasitas);
		$values1 = mysql_fetch_row($query_kapasitas);
		if ($values[0] == $values1[0]){
				echo "Maaf, Anda tidak dapat membatalkan tebengan ini";
			}
		else{
				// $result = mysql_query("UPDATE nebeng_beri_tebengan SET sisa_kapasitas=sisa_kapasitas+1 WHERE id_tebengan = '".$id_tebengan."'"		);
				$result = mysql_query("UPDATE nebeng_beri_tebengan SET sisa_kapasitas=sisa_kapasitas+1 WHERE user_id = '".$id_tebengan."'"		);
				$result = mysql_query("Delete from nebeng_nebeng WHERE id_penebeng = '".$user_id."'");
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
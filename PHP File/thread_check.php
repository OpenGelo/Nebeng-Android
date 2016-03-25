<?php
include("koneksi.php");
include_once("ldap.php");

		$username 		= $_POST['username'];
		$kapasitas		= $_POST['kapasitas'];
		$query_search = mysql_query("SELECT beri_tebengan.sisa_kapasitas FROM beri_tebengan INNER JOIN user ON beri_tebengan.user_id = user.id 
			WHERE user.username = '".$username."'");
		$extract_query_search = mysql_fetch_row($query_search);
		$sisa_kapasitas = $extract_query_search[0];
	
	if ($sisa_kapasitas == ''){
	echo "Tidak ada";
	}
	
	if($sisa_kapasitas < $kapasitas){
	echo "Tambah";
	}
	
	if ($sisa_kapasitas > $kapasitas){
	echo "Kurang";
	}

?>
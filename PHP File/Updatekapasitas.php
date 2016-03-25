<?php
include("koneksi.php");
 
// array for JSON response

 
$usernametujuan = $_POST['usernametujuan'];
$update = $_POST['update'];

$query_search = mysql_query("SELECT id FROM user WHERE username = '".$usernametujuan."'");
$result = mysql_fetch_row($query_search);
$id=$result[0];
//echo $id;

if($update=='nebeng'){
	
	
	echo "nebeng";
	//echo "Data gagal dimasukkan"; 
	
	/*$query_sisa_kapasitas = mysql_query("SELECT kapasitas FROM beri_tebengan WHERE user_id = '".$id."'");
	
	$kapasitas=$query_sisa_kapasitas[0];
	echo $kapasitas;
	if ( $kapasitas== 0){
				echo "Maaf kapasitas tidak cukup"; 
		}
	else {
		$alagamolang = mysql_query("Update beri_tebengan set kapasitas =kapasitas-1 where user_id = '".$result[0]."'");
		if(!$alagamolang) { 
    	echo "Data gagal dimasukkan";   }
 		else  {
    			echo "Data berhasil dimasukkan"; 
 			}
			
		}
	*/
}


else if($update=='konfirmasi'){
	echo "konfirmasi";
}
else if ($update=='batal') {
	echo "batal";
}
else{
	echo "Data gagal dimasukkan"; 
}
// check for empty result
?>
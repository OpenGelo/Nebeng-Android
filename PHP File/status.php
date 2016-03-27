<?php
//status.php 
/*
 * Following code will list all the products
 */
require_once("koneksi.php");

// array for JSON response
$response = array();

// connecting to db
//$db = new DB_CONNECT();

$username = $_POST['username'];
$query_search = mysql_query("SELECT id FROM nebeng_user WHERE username = '".$username."'");
$result = mysql_fetch_row($query_search);
$id=$result[0];
$query_search = mysql_query("SELECT user_id FROM nebeng_beri_tebengan WHERE user_id = '".$id."'");
$result = mysql_fetch_row($query_search);

if ($result[0]>'0') {
	$query_search = mysql_query("SELECT id_penebeng FROM nebeng_nebeng WHERE id_tebengan = '".$id."'");
	$result = mysql_fetch_row($query_search);
	if($result[0] > '0'){	
		
		$query_search = mysql_query("SELECT id_penebeng FROM nebeng_nebeng WHERE id_tebengan = '".$id."'");
		while ($row = mysql_fetch_array($query_search)) {	
			$response["hasil"] = array();
			$hasil = mysql_query("SELECT npm, nama, no_handphone, email FROM nebeng_user WHERE id = '".$row["id_penebeng"]."'");
			while($rowi = mysql_fetch_array($hasil)){
				
        	// temp user array
				$nebeng = array();
				$nebeng["npm"] = $rowi["npm"];
				$nebeng["nama"] = $rowi["nama"];
			//$nebeng["no_hp"] = $rowi["no_hp"];
			//$nebeng["no_telp"] = $rowi["no_telp"];
				$nebeng["no_hp"] = $rowi["no_handphone"];
				$nebeng["email"] = $rowi["email"];
				$nebeng["status"] = 'Nebengin';
				array_push($response["hasil"], $nebeng);
			}
			
		}
			// success
		$response["success"] = 1;
		
	}
	else
	{	
		$response["hasil"] = array();
		$nebeng = array();
		$nebeng["npm"] = 'Belum ada';
		$nebeng["nama"] = 'Belum ada';
				//$nebeng["no_hp"] = 'Belum ada';
				//$nebeng["no_telp"] = 'Belum ada';
		$nebeng["no_hp"] = 'Tidak ada';
		$nebeng["email"] = 'Tidak ada';
		$nebeng["status"] = 'Sedang memberikan Tebengan';
		array_push($response["hasil"], $nebeng);
		
		$response["success"] = 1;
		
		
	}
	
	
}
else
{	
	$query_search = mysql_query("SELECT id_penebeng FROM nebeng_nebeng WHERE id_penebeng = '".$id."'");
	$result = mysql_fetch_row($query_search);
	if ($result[0]>'0') {
		$query_search = mysql_query("SELECT id_tebengan FROM nebeng_nebeng WHERE id_penebeng = '".$id."'");
		while ($row = mysql_fetch_array($query_search)) {	
			$response["hasil"] = array();
			$hasil = mysql_query("SELECT npm, nama, no_handphone, email FROM nebeng_user WHERE id = '".$row["id_tebengan"]."'");
			while($rowi = mysql_fetch_array($hasil)){
				
        		// temp user array
				$nebeng = array();
				$nebeng["npm"] = $rowi["npm"];
				$nebeng["nama"] = $rowi["nama"];
				//$nebeng["no_hp"] = $rowi["no_hp"];
				//$nebeng["no_telp"] = $rowi["no_telp"];
				$nebeng["no_hp"] = $rowi["no_handphone"];
				$nebeng["email"] = $rowi["email"];
				$nebeng["status"] = 'Nebeng';
				array_push($response["hasil"], $nebeng);
			}
			
		}
		$response["success"] = 1;
		
	}
	else
	{	
		$query_search = mysql_query("SELECT id FROM nebeng_user WHERE username = '".$username."'");
		$result = mysql_fetch_row($query_search);
		if ($result){// success
			
			$response["hasil"] = array();
			$nebeng = array();
			$nebeng["npm"] = 'Tidak ada';
			$nebeng["nama"] = 'Tidak ada';
			$nebeng["no_hp"] = 'Tidak ada';
			$nebeng["email"] = 'Tidak ada';
			$nebeng["status"] = 'Bebas';
			
			array_push($response["hasil"], $nebeng);
			$response["success"] = 1;
		}
		else{
			// no products found
			$response["success"] = "0";
			$response["message"] = mysql_error();
		}
	}
}

echo json_encode($response);
?>
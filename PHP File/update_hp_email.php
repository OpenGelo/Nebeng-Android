<?php
include("koneksi.php");

//NO HANDPHONE DAN EMAIL

$username = $_POST['username'];
$no_handphone = $_POST['nomor'];
$email = $_POST['email'];

$query_update  = mysql_query("UPDATE user SET no_handphone = '".$no_handphone."', email = '".$email."' WHERE username = '".$username."'");

//query check
$query_check1 = mysql_query ("SELECT no_handphone FROM user WHERE username = '".$username."'");
$extract_query_check1 = mysql_fetch_row($query_check1);
$query_check2 = mysql_query ("SELECT email FROM user WHERE username = '".$username."'");
$extract_query_check2 = mysql_fetch_row($query_check2);

/*
$query_search2 = mysql_query("SELECT id_penebeng FROM nebeng WHERE id_penebeng = '".$user_id."'");
$query_search3 = mysql_query("SELECT user_id FROM beri_tebengan WHERE user_id = '".$user_id."'");
$extract_query_search2 = mysql_fetch_row($query_search2);
$extract_query_search3 = mysql_fetch_row($query_search3);
*/

 if ($extract_query_check1[0] && $extract_query_check2[0]){
						echo "Sukses";
						}

else {
	echo "Maaf Ada kesalahan";
} 

?>
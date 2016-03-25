<?php
require_once("koneksi.php");
//include_once("ldap.php");

		$npm 		= $_POST['username'];

$query_check = mysql_query("SELECT username FROM nebeng_user USER WHERE username = '".$npm."'");
$extract_query_check = mysql_fetch_row($query_check);

		if($extract_query_check)	
		{	echo "User Found";}
		else {echo "User Not Found";}

?>
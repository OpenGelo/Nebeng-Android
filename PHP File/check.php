<?php
require_once("koneksi.php");
require_once("ldap.php");

$user 		= trim($_POST['username']);
$password 	= $_POST['password'];
$reg_id		= $_POST['regid'];
$response 	= array();

if(empty($user) && empty($password)){	
	$response["result"] = "Masukkan Username dan Password Anda";
}
elseif(empty($password)){
	$response["result"] = "Masukkan Password Anda";
}
elseif(empty($user)){
	$response["result"] = "Masukkan Username Anda";	
}	
else
{			
	$user_data=ldap_auth($user,$password);
	if(!empty($user_data)){
		$userid		=$user_data[0];
		$npm		=$user_data[1];
		$role		=$user_data[2];
		$nama_user	=$user_data[3];
		$email		=$user_data[4];
		$kodeorg	=$user_data[5];

		$query_search = "select * from nebeng_user where username='$userid'";
		$query_exec = mysql_query($query_search) or die(mysql_error());
		$rows = mysql_num_rows($query_exec);
		if(!empty($rows)) { 
			$response["result"] = "User Found";							 
		}
		else{
			$query_add = "insert into nebeng_user 
			(nama,npm,username,role,email, reg_id) values 
			('$nama_user','$npm','$username','$role','$email','$reg_id')";
			$query_exec = mysql_query($query_add) or die(mysql_error());
			$response["result"] = "User New";
		}					
	}
	else{			
		$response["result"] = "No Such User Found";			
	}	
}
echo json_encode($response);
?>
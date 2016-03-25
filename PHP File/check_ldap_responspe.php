<?php
require_once("koneksi.php");
require_once("ldap.php");

$user 		= trim($_POST['username']);
$password 	= $_POST['password'];
$reg_id		= $_POST['regid'];

if(empty($user) && empty($password)){	
	$response = "Masukkan Username dan Password Anda";
}
elseif(empty($password)){
	$response = "Masukkan Password Anda";
}
elseif(empty($user)){
	$response = "Masukkan Username Anda";	
}	
else
{	
			
	$user_data=ldap_auth($user,$password);
	var_dump($user_data);	
}
echo json_encode($response);
?>
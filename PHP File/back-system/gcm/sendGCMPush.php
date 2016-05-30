<?php
/**
 * Endpoint push
 * Mengirim push ke android target dengan device berdasar token
 * Push sistem menggunakan GCM
 * 
 * @version 24 April 2016
 * @author I Made Sanadhi Sutandi // 1206202394
 */

//koneksi ke database
require_once("../db_connect.php");

$curlHandle; //menggunakan PHP-Curl request untuk melakukan request push API dari GCM

/**
 * Set Endpoint dan CURL Request untuk push
 * 
 */
function set_gcm_push($message, $device_token){ 
	$endpoint_push = "https://gcm-http.googleapis.com/gcm/send"; //endpoint dari API Push GCM

	global $curlHandle;
	$curlHandle = curl_init($endpoint_push);

	//inisialisasi header untuk Curl Request
	$headers = array(
	    'Content-type: application/json',
	    'Authorization: key=AIzaSyDfgdUt3tK3XBVn_Q4VTYMUuP4D8MiycfU'
	);

	//inisialisasi body request untuk Curl Request
	$post_fields = array(
	    'data'	=> array('message'	=>$message),	//kirim pesan tertentu
	    'to' 	=> "$device_token"					//devais android target secara spesifik
	);

	curl_setopt($curlHandle, CURLOPT_PROXY, "152.118.24.99"); 	//url proxy keluar dari server Nebeng
	curl_setopt($curlHandle, CURLOPT_PROXYPORT, "8080"); 		//port proxy 		
	
	curl_setopt($curlHandle, CURLOPT_HTTPHEADER, $headers);		//set header ke CURL
	curl_setopt($curlHandle, CURLOPT_POSTFIELDS, json_encode($post_fields));	//set body request ke CURL
	curl_setopt($curlHandle, CURLOPT_POST, 1); 
	curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, false);
}

/**
 * Eksekusi permintaan Curl yang sudah dibuat
 * 
 */
function exec_push(){
	global $curlHandle;
	$execResult = curl_exec($curlHandle);

	// Check for errors
	if($execResult === FALSE){
	    die(curl_error($curlHandle));
	}

	// Decode the response
	$responseData = json_decode($execResult, TRUE);

	// Print the date from the response
	echo $responseData['published'];
}
/**
 * Mengambil Token GCM dari devais pengguna yang tersimpan di database Nebeng
 * 
 */
function getToken($username){
	//ambil token gcm
	$query_search 	= mysql_query("SELECT gcm_token FROM nebeng_user WHERE username = '$username'") or die(mysql_error());
	$result 		= mysql_fetch_row($query_search);
	return $result[0];
}

//=====Main====//
	//get username and message
	if(isset($_POST['username']) && !empty($_POST['username'])){
		$user = $_POST['username'];
	}
	else{
		$user = 'sanadhi.sutandi';
	}

	if(isset($_POST['message']) && !empty($_POST['message'])){
		$message_accepted = $_POST['message'];
	}
	else{
		$message_accepted = 'Default GCM Message';
	}

	$token = getToken($user);

	//init and call the push
	set_gcm_push($message_accepted,$token);
	exec_push();
//=====Main====//

?>
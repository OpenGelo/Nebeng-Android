<?php
/**
 * Module Push untuk mengirimkan pesan GCM
 * Dapat diload (require/include) kemudian disesuaikan dengan case program PHP
 * 
 * @version 07 Juni 2016
 * @author I Made Sanadhi Sutandi // 1206202394
 */

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
	curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
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

	curl_close($curlHandle);
}

/**
 * Mengambil Token GCM dari devais pengguna yang tersimpan di database Nebeng berdasarkan username pengguna
 * 
 */
function getToken($username){
	//ambil token gcm
	$query_search 	= mysql_query("SELECT gcm_token FROM nebeng_user WHERE username = '$username'") or die(mysql_error());
	$result 		= mysql_fetch_row($query_search);
	return $result[0];
}

/**
 * Mengambil Token GCM dari devais pengguna yang tersimpan di database Nebeng berdasarkan id pengguna
 * 
 */
function getTokenById($id){
	//ambil token gcm
	$query_search 	= mysql_query("SELECT gcm_token FROM nebeng_user WHERE id = '$id'") or die(mysql_error());
	$result 		= mysql_fetch_row($query_search);
	return $result[0];
}

/**
 * Panggil function sendPush, kirimkan parameter username tujuan
 * serta pesan ke penerima pesan
 * 
 */
function sendPush($username,$message){
	//=====Main====//

	$token = getToken($username);

	//init and call the push
	set_gcm_push($message,$token);
	exec_push();
	//=====Main====//
}

/**
 * Panggil function sendPushById, kirimkan parameter id tujuan
 * serta pesan ke penerima pesan
 * 
 */
function sendPushById($id,$message){
	//=====Main====//

	$token = getTokenById($id);

	//init and call the push
	set_gcm_push($message,$token);
	exec_push();
	//=====Main====//
}

?>
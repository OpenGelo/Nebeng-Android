<?php
/**
 * Endpoint push
 * Mengirim push ke android target dengan device id tertentu
 * Push sistem menggunakan Bluemix IMFPUSH
 * 
 * @version 26 Maret 2016
 * @author I Made Sanadhi Sutandi // 1206202394
 */

$curlHandle; //menggunakan PHP-Curl request untuk melakukan request push API dari IBM Bluemix


/**
 * Set Endpoint dan CURL Request untuk push
 * 
 */
function set_bluemix_push($message, $user_id){ 
	$appId = "ff11fc50-a005-4c05-838b-74df51da0768";		//id dari aplikasi nebeng yang dibuat pada platfrom IBM Bluemix
	$appSecret = "a2c8e427-94f0-43de-988a-6649faf31615";	//secret key untuk aplikasi nebeng pada platform IBM Bluemix

	$endpoint_push = "https://mobile.ng.bluemix.net/imfpush/v1/apps/$appId/messages"; //endpoint dari API IMFPush Bluemix

	global $curlHandle;
	$curlHandle = curl_init($endpoint_push);

	//inisialisasi header untuk Curl Request
	$headers = array(
	    'Content-type: application/json',
	    'Accept: application/json',
	    "appSecret: $appSecret",
	    'Accept-Language: en-US'
	);

	//inisialisasi body request untuk Curl Request
	$post_fields = array(
	    'message'	=> array('alert'=>$message),				//kirim pesan tertentu
	    'target' 	=> array('userIds' => array($user_id))		//devais android target secara spesifik
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

//=====Main====//
	//get device's id and message
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
		$message_accepted = 'Default check/unicast';
	}

	//init and call the push
	set_bluemix_push($message_accepted,$user);
	exec_push();
//=====Main====//

?>
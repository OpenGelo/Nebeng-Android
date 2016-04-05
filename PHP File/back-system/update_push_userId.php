<?php
/**
 * Endpoint Update User Id dari suatu device id
 * Memberikan inisial (user id) ke devais target sesuai dengan username SIAK (LDAP UI)
 * Push sistem menggunakan Bluemix IMFPUSH
 * 
 * @version 04 April 2016
 * @author I Made Sanadhi Sutandi // 1206202394
 */

$curlHandle; //menggunakan PHP-Curl request untuk melakukan request push API dari IBM Bluemix


/**
 * Set Endpoint dan CURL Request untuk push
 * 
 */
function set_bluemix_push($device_id, $user_id){ 
	$appId = "ff11fc50-a005-4c05-838b-74df51da0768";		//id dari aplikasi nebeng yang dibuat pada platfrom IBM Bluemix

	$endpoint_update = "https://mobile.ng.bluemix.net/imfpush/v1/apps/$appId/devices/$device_id"; //endpoint device pada aplikasi nebeng

	global $curlHandle;
	$curlHandle = curl_init($endpoint_update);

	//inisialisasi header untuk Curl Request
	$headers = array(
	    'Content-type: application/json',
	    'Accept: application/json',
	    'Accept-Language: en-US'
	);

	//inisialisasi body request untuk Curl Request
	$post_fields = array(
	    'deviceId'	=> $device_id,				//device id
	    'userId' 	=> $user_id					//assign user id untuk device id bersangkutan
	);

	curl_setopt($curlHandle, CURLOPT_PROXY, "152.118.24.99"); 	//url proxy keluar dari server Nebeng
	curl_setopt($curlHandle, CURLOPT_PROXYPORT, "8080"); 		//port proxy 		
	
	curl_setopt($curlHandle, CURLOPT_HTTPHEADER, $headers);						//set header ke CURL
	curl_setopt($curlHandle, CURLOPT_POSTFIELDS, json_encode($post_fields));	//set body request ke CURL
	curl_setopt($curlHandle, CURLOPT_CUSTOMREQUEST, 'PUT'); 					//untuk update data device, digunakan http method PUT
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
	//get device's id and user id
	if(isset($_POST['device_id']) && !empty($_POST['device_id'])){
		$device = $_POST['device_id'];
	}
	else{
		$device = 'cf3797df-ea9f-3fa4-8ac7-aab68bea6508';
	}

	if(isset($_POST['username']) && !empty($_POST['username'])){
		$user_id = $_POST['username'];
	}
	else{
		$user_id = 'sanadhi.sutandi';
	}

	//init and call the push
	set_bluemix_push($device, $user_id);
	exec_push();
//=====Main====//

?>
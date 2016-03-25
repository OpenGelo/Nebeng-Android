<?php
$curlHandle;

function set_bluemix_push($message, $device_id){
	$endpoint_push = 'https://mobile.ng.bluemix.net/imfpush/v1/apps/ff11fc50-a005-4c05-838b-74df51da0768/messages';

	global $curlHandle;
	$curlHandle = curl_init($endpoint_push);

	$headers = array(
	    'Content-type: application/json',
	    'Accept: application/json',
	    'appSecret: a2c8e427-94f0-43de-988a-6649faf31615',
	    'Accept-Language: en-US'
	);

	$post_fields = array(
	    'message' => array('alert'=>$message),
	    'target' => array('deviceIds' => array($device_id))
	);

	curl_setopt($curlHandle, CURLOPT_PROXY, "152.118.24.99"); //your proxy url
	curl_setopt($curlHandle, CURLOPT_PROXYPORT, "8080"); // your proxy port number 		
	
	curl_setopt($curlHandle, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($curlHandle, CURLOPT_POSTFIELDS, json_encode($post_fields));
	curl_setopt($curlHandle, CURLOPT_POST, 1); 
	curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, false);
}

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


//main
//get device's id and message
if(isset($_POST['device_id']) && !empty($_POST['device_id'])){
	$device = $_POST['device_id'];
}
else{
	$device = 'cf3797df-ea9f-3fa4-8ac7-aab68bea6508';
}

if(isset($_POST['message']) && !empty($_POST['message'])){
	$message_accepted = $_POST['message'];
}
else{
	$message_accepted = 'Default check/unicast';
}

//init and call the push
set_bluemix_push($message_accepted,$device);
exec_push();

?>
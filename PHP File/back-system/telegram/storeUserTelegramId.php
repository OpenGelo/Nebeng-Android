<?php
/**
 * Endpoint Telegram API
 * Mengambil update dari endpoint untuk mencari data user id dari pengguna Telegram
 * Push sistem menggunakan Telegram Bot
 * 
 * @version 26 April 2016
 * @author I Made Sanadhi Sutandi // 1206202394
 */

//koneksi ke database
require_once("../db_connect.php");

$curlHandle; //menggunakan PHP-Curl request untuk melakukan request ke API telegram

/**
 * Set Endpoint dan CURL Request untuk http request
 * 
 */

function set_telegram_api(){ 
	$bot_token 		= "202889585:AAH51XJeUkXBtkbhcY7dLAvfYN6mAOiJSM4";

	$endpoint_api 	= "https://api.telegram.org/bot$bot_token/getUpdates"; //endpoint dari API Telegram

	global $curlHandle;
	$curlHandle = curl_init($endpoint_api);

	curl_setopt($curlHandle, CURLOPT_PROXY, "152.118.24.99"); 	//url proxy keluar dari server Nebeng
	curl_setopt($curlHandle, CURLOPT_PROXYPORT, "8080"); 		//port proxy 		
	
	curl_setopt($curlHandle, CURLOPT_POST, 1); 
	curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, false);
}

/**
 * Eksekusi permintaan Curl yang sudah dibuat
 * 
 */
function exec_curl_request(){
	global $curlHandle;
	$execResult = curl_exec($curlHandle);

	// Check for errors
	if($execResult === FALSE){
	    die(curl_error($curlHandle));
	}

	// Decode the response
	$responseData = json_decode($execResult, TRUE);

	return $responseData;
}

/**
 * Cek Id dari pengguna 
 * Return id dari pengguna Telegram apabila username ditemukan
 * Return null apabila pengguna dengan username yang dicari tidak ditemukan
 */
function getTelegramId($response, $telegramUsername){
	foreach ($response['result'] as $result) {
		$telegramId=null;
		try{
			if($result['message']['from']['username']==$telegramUsername)
				$telegramId = $result['message']['from']['id'];
		}
		catch(Exception $e) {
		  	echo 'Message: ' .$e->getMessage();
		}
		return $telegramId;
	}
}

/**
 * Update table nebeng_user
 * Menambahkan field telegram_id
 */
function storeTelegramId($username, $telegramId){
	//lakukan update
	$query_update	= mysql_query("Update nebeng_user set telegram_id='$telegramId' WHERE username = '$username'") or die(mysql_error());
}

//=====Main====//

	//get username and telegram username
	if(isset($_POST['username']) && !empty($_POST['username'])){
		$user = $_POST['username'];
	}
	else{
		$user = 'sanadhi.sutandi';
	}

	if(isset($_POST['telegramUsername']) && !empty($_POST['telegramUsername'])){
		$telegramUsername = $_POST['telegramUsername'];
	}
	else{
		$telegramUsername = 'sanadhisutandi';
	}

	//init and call the api
	set_telegram_api();
	$telegram_userId = getTelegramId(exec_curl_request(), $telegramUsername);

	if($telegram_userId){ //jika id yang dicari ditemukan atau tidak null
		storeTelegramId($user,$telegram_userId);
		$response["result"] = "Berhasil";
	}
	else{
		$response["result"] = "Gagal";
	}

	//tampilkan respon dalam array json
	echo json_encode($response);

//=====Main====//

?>
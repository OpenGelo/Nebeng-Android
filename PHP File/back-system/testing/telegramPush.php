<?php
/**
 * Endpoint push
 * Mengirim push ke android target dengan device berdasar id chat
 * Push sistem menggunakan Telegram Bot
 * 
 * @version 26 April 2016
 * @author I Made Sanadhi Sutandi // 1206202394
 */

//koneksi ke database
require_once("../db_connect.php");
$sukses=0;

$curlHandle; //menggunakan PHP-Curl request untuk melakukan request push API dari Telegram Bot

/**
 * Set Endpoint dan CURL Request untuk push
 * 
 */

function set_telegram_push(){ 
	$bot_token 		= "202889585:AAH51XJeUkXBtkbhcY7dLAvfYN6mAOiJSM4";

	$endpoint_push 	= "https://api.telegram.org/bot$bot_token/sendMessage"; //endpoint dari API Push Bot Telegram

	global $curlHandle;
	$curlHandle = curl_init($endpoint_push);

	//inisialisasi header untuk Curl Request
	$headers = array(
	    'Content-type: application/json'
	);

	

	curl_setopt($curlHandle, CURLOPT_PROXY, "152.118.24.99"); 	//url proxy keluar dari server Nebeng
	curl_setopt($curlHandle, CURLOPT_PROXYPORT, "8080"); 		//port proxy 		
	
	curl_setopt($curlHandle, CURLOPT_HTTPHEADER, $headers);		//set header ke CURL
	curl_setopt($curlHandle, CURLOPT_POST, 1); 
	curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, false);
}

/**
 * Eksekusi permintaan Curl yang sudah dibuat
 * 
 */
function exec_push($message, $chat_id,$value){
	global $curlHandle;

	//inisialisasi body request untuk Curl Request
	$post_fields = array(
	    'text'		=> "cek : $value",	//kirim pesan tertentu
	    'chat_id' 	=> $chat_id		//pengguna target
	);

	curl_setopt($curlHandle, CURLOPT_POSTFIELDS, json_encode($post_fields));	//set body request ke CURL

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
 * Mengambil Telegram Id dari pengguna yang tersimpan di database Nebeng
 * 
 */
function getTelegramId($username){
	//ambil id telegram
	$query_search 	= mysql_query("SELECT telegram_id FROM nebeng_user WHERE username = '$username'") or die(mysql_error());
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
		$message_accepted = 'Default Telegram Bot Message';
	}

	$user = getTelegramId($user);
	set_telegram_push();
	for ($i=0; $i < 100; $i++) { 
		exec_push($message_accepted,$user,$i);
	}
//=====Main====//

?>
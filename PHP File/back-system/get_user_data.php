<?php

/**
 * Program untuk fetch data user dari database
 * Mengambil npm, nama, dan role 
 * Param yang dikirim adalah username dari POST
 * 
 * @version 29 Maret 2016
 * @author I Made Sanadhi Sutandi // 1206202394
 */

//database connect
require_once("db_connect.php");

//variable post
$username   = $_POST['username'];

$response   = array();  //variable respon

//ambil data pengguna dari table nebeng_user
$get_user   = mysql_query("SELECT npm,nama,role FROM nebeng_user where username = '$username'") or die(mysql_error());

    if ($get_user) { //jika data user terdapat di table

        $response["result"] = array();  //array untuk menampung hasil data
        
        while ($row = mysql_fetch_array($get_user)) { //iterasi untuk mengakses per row dari hasil fecth table nebeng
            
            $user           = array();
            $user["npm"]    = $row["npm"];
            $user["nama"]   = $row["nama"];
            $user["role"]   = $row["role"];
            
            array_push($response["result"], $user); //push ke array responses
        }
        
        $response["success"] = 1;
        
    } 
    else { //jika data user tidak terdapat di table
        
        $response["success"] = 0;
        $response["message"] = mysql_error();
        
    }

//tampilkan respon dalam array json
echo json_encode($response);
?>
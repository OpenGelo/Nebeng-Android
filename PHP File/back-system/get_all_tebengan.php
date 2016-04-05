<?php

/**
 * List seluruh data tebengan yang tersedia
 * Menyeleksi tebengan yang kadaluarsa. Tebengan yang sudah kadaluarsa tidak diambil dari database
 * Melakukan join antar dua tabel
 * 
 * @version 05 April 2016
 * @author I Made Sanadhi Sutandi // 1206202394
 */

require_once("db_connect.php");
 
// array for JSON response
$response = array();

//waktu dan tanggal saat ini digunakan untuk menentukan expiry dari suatu tebengan
date_default_timezone_set("Asia/Jakarta");
$date_expired         = date_create(date('Y/m/d'));
$dateExpiredToString  = $date_expired->format('Y/m/d');
$time_expired         = date_create(date('H:i:s'));
$timeExpiredToString  = $time_expired->format('H:i:s');

    //ambil data dari tabel nebeng_user dan nebeng_beri_tebengan menggunakan join, ambil yang waktu kadaluarsanya sehabis waktu sekarang
    $query_join = mysql_query("SELECT user_id, id_tebengan, nebeng_user.nama, nebeng_user.npm, nebeng_user.username, asal, tujuan, sisa_kapasitas,waktu_berangkat, jam_berangkat, jam_kadaluarsa,keterangan
    				      FROM nebeng_beri_tebengan 
    				      INNER JOIN nebeng_user ON nebeng_beri_tebengan.user_id = nebeng_user.id 
                  		  WHERE (waktu_berangkat >= '$dateExpiredToString' AND jam_kadaluarsa >= '$timeExpiredToString')
    				      ORDER BY waktu_berangkat, jam_berangkat; 
    				      ") or die(mysql_error());
	
    if ($query_join) { //jika terdapat tebengan yang masih tersedia

           $beri_tebengan       = array();  // temp user array
           $response["result"]  = array();
           $count               = 0;        // menghitung baris respon

           while ($row = mysql_fetch_array($query_join)) { //loop untuk record per barisnya
              
    		      $beri_tebengan["user_id"]         = $row["user_id"];
    		      $beri_tebengan["id_tebengan"]     = $row["id_tebengan"];
              $beri_tebengan["npm"]             = $row["npm"];
              $beri_tebengan["nama"]            = $row["nama"];
              $beri_tebengan["username"]        = $row["username"];
              $beri_tebengan["asal"]            = $row["asal"];
              $beri_tebengan["tujuan"]          = $row["tujuan"];
              $beri_tebengan["kapasitas"]       = $row["sisa_kapasitas"];
              $beri_tebengan["waktu_berangkat"] = $row["waktu_berangkat"];
  		        $beri_tebengan["jam_berangkat"]   = $row["jam_berangkat"];
            	$beri_tebengan["keterangan"]      = $row["keterangan"];
     
              // push satu array per baris untuk tiap loop ke array response akhir
              array_push($response["result"], $beri_tebengan);
              $count++;
           }

           if ($count==0){ //jika tidak terdapat tebengan tersedia
             $response["success"] = "2";
           }
           else{  //jika terdapat tebengan yang tersedia
             $response["success"] = "1";
           }
    } 

    else {  //jika gagal akses ke table join
        $response["success"] = 0;
        $response["message"] = mysql_error();
    }

//tampilkan respon dalam array json
echo json_encode($response);
?>
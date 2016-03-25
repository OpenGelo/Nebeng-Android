<?php
//room_beri_tebengan.php
 
/*
 * Following code will list all the products
 */
require_once("koneksi.php");
 
// array for JSON response
$response = array();
 
// connecting to db
//$db = new DB_CONNECT();

$kode = $_POST['kode'];
//Tebengan Kadaluarsa
date_default_timezone_set("Asia/Jakarta");
$date_expired = date_create(date('Y/m/d'));
//date_time_set($date_expired, 00,00);
$dateExpiredToString = $date_expired->format('Y/m/d');
$time_expired = date_create(date('H:i:s'));
$timeExpiredToString = $time_expired->format('H:i:s');
//echo $timeExpiredToString;
/*
$getDate = mysql_query("SELECT waktu_berangkat FROM beri_tebengan");
$getDateValues = mysql_result($getDate,0);

while($getDateValues) {
//var_dump ($getDateValues);
}

//echo $getDateValues."<br>";
//echo $dateExpiredToString;
//$ttbe = date("m/d/Y H:i")."<br>";
//echo $ttbe;

//$ttbe = (date('m/d/Y H:i'));
//echo $ttbe."<br>";
if($getDateValues < $dateExpiredToString)
{}
*/

// get all products from products table
/*
$result = mysql_query("SELECT user_id, user.nama, user.npm, asal, tujuan, sisa_kapasitas,waktu_berangkat, jam_berangkat
				FROM beri_tebengan WHERE waktu_berangkat > '".$dateExpiredToString."'
				INNER JOIN user
				ON beri_tebengan.user_id=user.id");
 */

//echo $dateExpiredToString ."<br>";

 $result = mysql_query("SELECT user_id, nebeng_user.nama, nebeng_user.npm, asal, tujuan, sisa_kapasitas,waktu_berangkat, jam_berangkat, keterangan
				FROM nebeng_beri_tebengan 
				INNER JOIN nebeng_user ON nebeng_beri_tebengan.user_id = nebeng_user.id WHERE (waktu_berangkat >= '".$dateExpiredToString."' AND jam_berangkat >= '".$timeExpiredToString."')
				ORDER BY waktu_berangkat, jam_berangkat; 
				");

				/*
$sisa_kapasitas_transaction = mysql_query("
START TRANSACTION;
  UPDATE room_beri_tebengan
    SET sisa_kapasitas = kapasitas
    WHERE id = LAST_INSERT_ID();
COMMIT ;
");				
	*/
	
// check for empty result
if ($result) {
       // looping through all results
       // products node
       $response["result"] = array();
       $count=0;

       while ($row = mysql_fetch_array($result)) {
          // temp user array
          $beri_tebengan = array();
		$beri_tebengan["user_id"] = $row["user_id"];
          $beri_tebengan["npm"] = $row["npm"];
          $beri_tebengan["nama"] = $row["nama"];
          $beri_tebengan["asal"] = $row["asal"];
          $beri_tebengan["tujuan"] = $row["tujuan"];
          $beri_tebengan["kapasitas"] = $row["sisa_kapasitas"];
          $beri_tebengan["waktu_berangkat"] = $row["waktu_berangkat"];
		$beri_tebengan["jam_berangkat"] = $row["jam_berangkat"];
          $beri_tebengan["keterangan"] = $row["keterangan"];
 
          // push single product into final response array
          array_push($response["result"], $beri_tebengan);
          $count++;
       }
       // success
       if ($count==0){
         $response["success"] = "2";
       }else{
         $response["success"] = "1";
       }
} else {
    // no products found
    $response["success"] = 0;
    $response["message"] = mysql_error();
 
}
    if($kode==1)
       echo json_encode($response);
    else
       {}
?>
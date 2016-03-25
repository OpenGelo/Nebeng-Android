<?php
 
/*
 * Following code will list all the products
 */
require_once 'db_connect.php';
 
// array for JSON response
$response = array();
 
// connecting to db
$db = new DB_CONNECT();
 
// get all products from products table
$result = mysql_query("SELECT id,nama,asal,tujuan,kapasitas,unix_timestamp(waktu_berangkat) FROM beri_tebengan");
 
// check for empty result
if ($result) {
    // looping through all results
    // products node
    $response["result"] = array();
 
    while ($row = mysql_fetch_array($result)) {
        // temp user array
        $beri_tebengan = array();
        $beri_tebengan["npm"] = $row["npm"];
        $beri_tebengan["nama"] = $row["nama"];
        $beri_tebengan["asal"] = $row["asal"];
        $beri_tebengan["tujuan"] = $row["tujuan"];
        $beri_tebengan["kapasitas"] = $row["kapasitas"];
        $beri_tebengan["waktu_berangkat"] = $row["waktu_berangkat"];
 
        // push single product into final response array
        array_push($response["result"], $beri_tebengan);
    }
    // success
    $response["success"] = 1;
 
} else {
    // no products found
    $response["success"] = 0;
    $response["message"] = mysql_error();
 
}

    echo json_encode($response);
?>
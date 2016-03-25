<?php
 
/*
 * Following code will list all the products
 */
include("koneksi.php");
 
// array for JSON response
$response = array();

 
// get all products from products table
$result = mysql_query("SELECT * FROM traffic");
 
// check for empty result
if ($result) {
    // looping through all results
    // products node
    $response["result"] = array();
 
    while ($row = mysql_fetch_array($result)) {
        // temp user array
        $traffic = array();
        $traffic["lokasi"] = $row["lokasi"];
        $traffic["keterangan"] = $row["keterangan"];
 
        // push single product into final response array
        array_push($response["result"], $traffic);
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
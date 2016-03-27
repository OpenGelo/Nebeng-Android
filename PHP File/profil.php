<?php
require_once("koneksi.php");
// array for JSON response


// connecting to db
//$db = new DB_CONNECT();

$username = $_POST['username'];
$result = mysql_query("SELECT npm,nama,role FROM nebeng_user where username = '".$username."'");
// check for empty result
if ($result) {
    // looping through all results
    // products node
    $response["result"] = array();
    
    while ($row = mysql_fetch_array($result)) {
        // temp user array
        $user = array();
        $user["npm"] = $row["npm"];
        $user["nama"] = $row["nama"];
        $user["role"] = $row["role"];
        /*
        $user["jenis_kelamin"] = $row["jenis_kelamin"];
        $user["alamat"] = $row["alamat"];
        $user["email"] = $row["email"];
        $user["no_hp"] = $row["no_hp"];
        $user["no_telp"] = $row["no_telp"];
        */ 
        // push single product into final response array
        array_push($response["result"], $user);
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
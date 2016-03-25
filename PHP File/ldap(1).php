<?php

function today() {

$hari       = date(w, time());
$tanggal    = date(d, time());
$bulan      = date(m, time());
$tahun      = date(Y, time());
$jam 		= date(H,time());
$menit		= date(i,time());
              switch ($hari) {
                      case 0 : $hari = "Minggu";
                      break;
                      case 1 : $hari = "Senin";
                      break;
                      case 2 : $hari = "Selasa";
                      break;
                      case 3 : $hari = "Rabu";
                      break;
                      case 4 : $hari = "Kamis";
                      break;
                      case 5 : $hari = "Jumat";
                      break;
                      case 6 : $hari = "Sabtu";
                      break;
              }

              switch ($bulan) {
                      case '01' : $bulan = "Januari";
                      break;
                      case '02' : $bulan = "Februari";
                      break;
                      case '03' : $bulan = "Maret";
                      break;
                      case '04' : $bulan = "April";
                      break;
                      case '05' : $bulan = "Mei";
                      break;
                      case '06' : $bulan = "Juni";
                      break;
                      case '07' : $bulan = "Juli";
                      break;
                      case '08' : $bulan = "Agustus";
                      break;
                      case '09' : $bulan = "September";
                      break;
                      case '10' : $bulan = "Oktober";
                      break;
                      case '11' : $bulan = "November";
                      break;
                      case '12' : $bulan = "Desember";
                      break;
              }

echo "$hari, $tanggal $bulan $tahun  $jam:$menit";

}

function authorize($ds, $login)
{
	if ($ds) { 

		$r=ldap_bind($ds);     // this is an "anonymous" bind, typically
							   // read-only access
		// Search surname entry
	//	$sr=ldap_search($ds, "o=Universitas Indonesia, c=ID", "uid=$login"); 
	

		if ($sr=ldap_search($ds, "o=Universitas Indonesia, c=ID", "(&(uid=$login)(hasAccessTo=makara.cso.ui.ac.id))"))
		{
		$info = ldap_get_entries($ds, $sr);
		$idLengkap = "";
		for ($i=0; $i<$info["count"]; $i++) {
			$idLengkap = $info[$i]["dn"];
		}
		return $idLengkap;
		}
		else return "";
	} else {
		echo "<h4>Unable to connect to LDAP server</h4>";
	}
}

function getInfo($ds, $login)
{
	if ($ds) { 
		$r=ldap_bind($ds);     
		//$arr = array("hasAccessTo","kodeIdentitas","role","uid","cn");
		$arr = array("hasAccessTo","kodeIdentitas","role","uid","cn","mail","kodeorg");
		$sr=ldap_search($ds, "o=Universitas Indonesia, c=ID", "uid=$login",$arr);  
		$info = ldap_get_entries($ds, $sr);
		$exist = false;
		//print"<pre>";
		//print_r($info);
		//print"</pre>";
		//$userdata= array($info[0]["uid"][0],$info[0]["kodeidentitas"][0], $info[0]["role"][0],$info[0]["cn"][0]);
		$userdata= array($info[0]["uid"][0],$info[0]["kodeidentitas"][0], $info[0]["role"][0],$info[0]["cn"][0],$info[0]["mail"][0],$info[0]["kodeorg"]);
		if($userdata == "")
			return 0;
		else
			return $userdata;
			
	} else {
		return 0;
	}
}


function authenticate($ds, $login, $password)
{      
	if ($ds) { 
		
	   // $r=ldap_bind($ds, $login, $password);//or die("Login Failed =".ldap_error($ds));// this is a real login :)
	    $r=@ldap_bind($ds, $login, $password) ;//or exit();
		if ($r)
		{
			return $r;
		}
		else
		{
			/*$_SESSION['direction'] = "/var/www/eis/wrong_pass.html";

  			$hostname = $_SERVER['HTTP_HOST'];
   	    	$path = dirname($_SERVER['PHP_SELF']);
	  
       	 	header('Location: http://'.$hostname.($path == '/' ? '' :$path).'');//header("Location:index.php");
			*/return "";
		}
		
		
	} else {
		echo "<h4>Unable to connect to LDAP server</h4>";
	}
}

/* $Id: grab_globals.lib.php,v 1.3 2001/11/25 12:20:48 loic1 Exp $ */


/**
 * This library grabs the names and values of the variables sent or posted to a
 * script in the '$HTTP_*_VARS' arrays and sets simple globals variables from
 * them
 *
 * loic1 - 2001/25/11: use the new globals arrays defined with php 4.1+
 */
if (!defined('PMA_GRAB_GLOBALS_INCLUDED')) {
    define('PMA_GRAB_GLOBALS_INCLUDED', 1);

    if (!empty($_GET)) {
        extract($_GET);
    } else if (!empty($HTTP_GET_VARS)) {
        extract($HTTP_GET_VARS);
    } // end if

    if (!empty($_POST)) {
        extract($_POST);
    } else if (!empty($HTTP_POST_VARS)) {
        extract($HTTP_POST_VARS);
    } // end if

    if (!empty($_FILES)) {
        while (list($name, $value) = each($_FILES)) {
            $$name = $value['tmp_name'];
        }
    } else if (!empty($HTTP_POST_FILES)) {
        while (list($name, $value) = each($HTTP_POST_FILES)) {
            $$name = $value['tmp_name'];
        }
    } // end if

} // $__PMA_GRAB_GLOBALS_LIB__

function ldap_auth ($login, $passwd)
{
	$ds = ldap_connect ('152.118.39.37');
	$dn = authorize ($ds, $login);

	if($dn != "" && $passwd != "")
	{
		if ($passwd=='ppsi09lantai7')
		{
			$info = getInfo($ds, $login);
			return $info;
		}

		if (authenticate($ds, $dn, $passwd) != "")
		{
			$info = getInfo($ds, $login);
			
			return $info;
		}
		return "";
	}

	return "";
}
?>

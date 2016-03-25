<?php
//include("koneksi.php");
//include_once("ldap.php");

		$npm 		= $_POST['username'];
		$password 	= $_POST['password'];
		if(!empty($npm)&&!empty($password)){
			//echo $npm.' --- '.$password;
			$myFile = "testFile.txt";
			$fh = fopen($myFile, 'w') or die("can't open file");
			$stringData = time()."-ok\n";
			fwrite($fh, $stringData);
			fclose($fh);
		}else{
			$myFile = "testFile.txt";
			$fh = fopen($myFile, 'w') or die("can't open file");
			$stringData = time()."-er\n";
			fwrite($fh, $stringData);
			fclose($fh);
		}
		die('empty');
		
		$user		= $npm;
		$user		= trim($user);
		
		if($user=='')	
		{	echo "Masukkan Username Anda";}
		elseif($password=='')	
		{	echo "Masukkan Password Anda";}
		elseif($user=='' && $password=='')
		{	echo "Masukkan Username dan Password Anda";	}	
		elseif($user!='' && $password!='')	
		{		
			$user=ldap_auth($user,$password);
					if($user !="")
						{
							$userid		=$user[0];
							$npm		=$user[1];
							$role		=$user[2];
							$nama_user	=$user[3];
							$kodeorg	=$user[5];

							$query_search = "select * from user where username='$userid'";
							$query_exec = mysql_query($query_search) or die(mysql_error());
							$rows = mysql_num_rows($query_exec);
							 if($rows!='') { 
								 echo"User Found";							 
							 }
							 else{
								 echo "Belum terdaftar dalam aplikasi"; 
							 }
							//echo "User Found";					
						}			
							else
						{			
							echo "No Such User Found";			
						}	
		}
/*
$query_search = "select * from user where npm = '".$npm."' AND password = '".$password. "'";
$query_exec = mysql_query($query_search) or die(mysql_error());
$rows = mysql_num_rows($query_exec);
//echo $rows;
 if($rows == 0) { 
 echo "No Such User Found"; 
 }
 else  {
    echo "User Found"; 
}
*/

//$asdfgh = file_get_contents('http://sirip.ui.ac.id/ijor/tools/cek_aktif.php?npm='.$npm);

?>
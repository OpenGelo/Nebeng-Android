<?php
include("koneksi.php");
include_once("ldap.php");

		$npm 		= $_POST['username'];
		$password 	= $_POST['password'];
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
	                /*
			$query_search = "select * from user where npm = '".$npm."' AND password = '".$password. "'";
			$query_exec = mysql_query($query_search) or die(mysql_error());
			$rows = mysql_num_rows($query_exec);
			if($rows == 0) { 
				echo "No Such User Found"; 
			}else{
				echo "User Found"; 
			}*/

		
			$user=ldap_auth($user,$password);
			if($user !=""){
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
                                         session_start();
                                         $_SESSION['login_user'] = $nama_user;
                                         $_SESSION['login_npm'] = $npm;
                                         $_SESSION['login_role']= $role;
                                         header('location:index_user.php');							 
				 }
				 else{
					$query_add = "insert into user 
                                         (nama,npm,username,role, reg_id) values 
                                         ('$nama_user','$npm','$username','$role','None')";
					$query_exec = mysql_query($query_add) or die(mysql_error());
                                        echo"User New";
                                         session_start();
                                         $_SESSION['login_user'] = $nama_user;
                                         $_SESSION['login_npm'] = $npm;
                                         $_SESSION['login_role'] = $role;
                                        header('location:index_user.php');	
				 }
				//echo "User Found";
				/*echo $userid;
				echo $npm;
				echo $role;
				echo $nama_user;
				echo $kodeorg;*/					
			}else{			
				echo "No Such User Found";	
		                header('location:index1.php');
				//echo "User Found";			
			}	
		
		}

//$asdfgh = file_get_contents('http://sirip.ui.ac.id/ijor/tools/cek_aktif.php?npm='.$npm);

?>
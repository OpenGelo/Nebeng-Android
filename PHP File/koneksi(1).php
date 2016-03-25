<?php
$hostname_localhost ="localhost";
$database_localhost ="green_ui_ac_id_iot";
$username_localhost ="green.ui.ac.id";
$password_localhost ="cha7Iesh";

$localhost = mysql_connect($hostname_localhost,$username_localhost,$password_localhost)
or
trigger_error(mysql_error(),E_USER_ERROR);
 
mysql_select_db($database_localhost, $localhost);
?>
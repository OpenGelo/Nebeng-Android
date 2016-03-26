<?php
/**
 * Credentials dari database Nebeng
 * koneksi ke db.ui.ac.id dan ke database nebeng
 * 
 * @version 26 Maret 2016
 * @author I Made Sanadhi Sutandi // 1206202394
 */

define("DB_HOST", "db.ui.ac.id");			//db host
define("DB_NAME", "green_ui_ac_id_1");		//db name
define("DB_USERNAME", "green.ui.ac.id");	//db user
define("DB_PASS", "cha7Iesh");				//db pass

$db_connect = mysql_connect(DB_HOST,DB_USERNAME,DB_PASS) //connect or trigger error
or
trigger_error(mysql_error(),E_USER_ERROR);
 
mysql_select_db(DB_NAME, $db_connect);	//connect ke database green_ui_ac_id_1
?>
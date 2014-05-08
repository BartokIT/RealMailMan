<?php

include_once "lib/ezSQL/shared/ez_sql_core.php";
include_once "lib/ezSQL/mysqli/ez_sql_mysqli.php";
//include_once "lib/ezSQL/mssql/ez_sql_mssql.php";


$db_host="localhost";
$db_name="realmail_manager";
$db_user="root";
$db_pass="root";
/*
$db_host='SERVER2K3\SQLEXPRESS';
$db_name="POSTA";
$db_user="postino";
$db_pass="postino";
*/
global $id_db_connection,$db;
//$id_db_connection = @mysql_connect($db_host, $db_user, $db_pass);
$db = new ezSQL_mysqli($db_user, $db_pass, $db_name, $db_host); 
//$db = new ezSQL_mssql($db_user, $db_pass, $db_name, $db_host);
//$other_db_tables = $db->get_results("SHOW TABLES");
//$db->debug();


/*
if (!$id_db_connection)
{
	echo <<<EOF
	<div style="text-align:center">
		<div style="margin:auto; border: 3px dashed red;width:20em;height:5em;line-height:5em;">
			Impossibile connettersi al server database
		</div>	
	</div>
EOF;
	die();
}

if (!mysql_select_db($db_name,$id_db_connection))
{
	echo <<<EOF
	<div style="text-align:center">
		<div style="margin:auto; border: 3px dashed red;width:20em;height:5em;line-height:5em;">
			Impossibile connettersi al database
		</div>	
	</div>
EOF;
	die();
}
mysql_query("SET NAMES utf8");*/
?>

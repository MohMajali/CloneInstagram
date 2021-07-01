<?php

error_reporting(0);

$db_name = "id2924857_instagram";
$mysql_user = "id2924857_instagram";
$mysql_pass = "mariooo";
$server_name = "localhost";

$con = mysqli_connect($server_name, $mysql_user, $mysql_pass, $db_name);

if(!$con){
	echo '{"message":"Unable to connect to the database."}';
}

?>
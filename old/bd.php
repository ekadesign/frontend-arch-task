<?php
$dbName='/app/db.sqlite';

$db = new SQLite3($dbName);
if($db){
	return "connect";
}else{
	die();
}

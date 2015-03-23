<?php

$db_host = "localhost";
$db_user = "root";
$db_pass = "root";
$db_name = "test";

$db = new mysqli($db_host, $db_user, $db_pass, $db_name);
if ($db->connect_error) {
	die("Connection failed: " . $db->connect_error);
}

if(!$db->multi_query(file_get_contents("database.sql")))
	print "Error in creating the db: ".$db->error;

print "End installation";
?>

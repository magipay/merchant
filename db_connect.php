<?php

$DB_HOST =	"localhost";				
$DB_USERNAME = 	"PLACE YOUR DATABASE USERNAME HERE";				
$DB_PASSWORD = 	"PLACE YOUR DATABASE PASSWORD HERE";				
$DB_NAME = 	"PLACE NAME OF YOUR DATABASE HERE";					

$db_conx = mysqli_connect($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);

if (mysqli_connect_errno()) {
    echo mysqli_connect_error();
    exit();
}
?>
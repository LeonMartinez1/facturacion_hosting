<?php 
error_reporting(E_ALL ^ E_NOTICE);
session_start();

function superConn(){

	define('MYSQL_HOST','localhost');
    define('MYSQL_DB','cfdi40_facturacion');

	define('MYSQL_USER','cfdi40_userfact');
	define('MYSQL_PASS','gXgQgG=aYKNm');

	if(!$conn=mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASS,MYSQL_DB))
	die (mysqli_error("test")); 
	
	return $conn;
}



?>
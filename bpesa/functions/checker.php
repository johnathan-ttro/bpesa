<?php
//turn off deprecicated warnings
error_reporting(E_ALL ^ E_DEPRECATED);
require_once '../config.php';

if(isset($_POST['action']) && $_POST['action'] == 'email_availability'){ // Check for the username posted
	$email = htmlentities($_POST['email']); // Get the username values
	$dbconnect = NEW DB_Class();
	$getEmailSql = "SELECT userEmail FROM users WHERE userEmail = '" . $email . "'";
	$getOneEmail = $dbconnect->getone($getEmailSql);
	echo $getOneEmail == true ? '1' : '0' ;
}
?>
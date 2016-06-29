<?php
//turn off deprecicated warnings
error_reporting(E_ALL ^ E_DEPRECATED);
$page_title = 'BpeSA skills Portal - Courses';
require_once '../config.php';
require_once '../header.php';
include '../sessionTest.php';


$dbconnect = NEW DB_Class();

$date = date('m/d/Y');
if(!empty($_POST)){
//IMPOTRANT: the sender ID and recipient ID are swopped around in a 'reply' siutation
$emailSendSql = "INSERT INTO message_table(messageRecipientId, messageSenderId, messageParentId, messageSubject, message, messageDate, messageRead, messageDeleted)
                 VALUES (" . $_POST['senderId']  . ", " . $_POST['recipientId'] . ", ". $_POST['parentId'] . ", '" . $_POST['subject'] . "', '" . mysql_real_escape_string($_POST['message']) . "', '" . $date . "', 'N', 'N')";

$actualEmailAddressSql = 'SELECT userEmail FROM users WHERE id =' . $_POST['recipientId'];
$actualEmailAddress = $dbconnect->getone($actualEmailAddressSql);

//TODO
/*
$to      = $actualEmailAddress;
$subject = $_POST['subject'];
$message = $_POST['message'];
$headers = 'From: BPeSA Skills Portal';

mail($to, $subject, $message, $headers);
*/
$emailSendSql = $dbconnect->query($emailSendSql);
	if($emailSendSql) {
	  echo '<h2 class="text-center"> Thank you, your mail has been sent.</h2>';
	}

}
include '../footer.php';
?>

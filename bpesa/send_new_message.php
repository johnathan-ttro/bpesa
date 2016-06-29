<?php
//turn off deprecicated warnings
error_reporting(E_ALL ^ E_DEPRECATED);
require_once 'config.php';
require_once 'header.php';
include 'sessionTest.php';

$date = date('m/d/Y');

$dbconnect = NEW DB_Class();

if(!empty($_POST['message'])) {
  $adminMessage = strip_word_html($_POST['message']);  
  $addNewEmailMessageSql = "INSERT INTO message_table (messageRecipientId, messageSenderId, messageSubject, message, messageDate, messageRead, messageDeleted)
                            VALUES (" . $_POST['recipientId'] . ", " . $_POST['senderId'] . ", '" . $_POST['subject'] . "', '" . mysql_real_escape_string($adminMessage) . "',  '" . $date . "', 'N', 'N')";
  $addNewEmailMessageSql = $dbconnect->query($addNewEmailMessageSql);
  if($addNewEmailMessageSql) {
    echo '<h4 class="text-center">You message has been successfully sent</h4>';
  } else {
    echo '<h4 class="text-center">There was a problem sending the email</h4>';
  }
} 

$selectRecipientAddressSql = 'SELECT userEmail FROM users WHERE id = ' . $_POST['recipientId'];
$selectRecipientAddress = $dbconnect->getone($selectRecipientAddressSql);

    $to = $selectRecipientAddress;
    $subject = $_POST['subject'];
    $message = "
    <html>
    <head>
		<title>BPeSA Email system</title>
    </head>
    <body>
		<h3>You have recieved an email on the BPeSA skills potal.</h3>
		<p>Below is the copy of the email, to reply, please log on to the BPeSA Skills portal and reply using the internal mail system.<br />please do not reply to this email address as it is automated.</p>
		<table>
		<p>" . $_POST['message'] . "</p>
    </body>
    </html>";

    // Always set content-type when sending HTML email
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";

    // More headers
    $headers .= 'From: BPeSA Skills Portal';
    mail($to,$subject,$message,$headers);

include 'footer.php';
?>

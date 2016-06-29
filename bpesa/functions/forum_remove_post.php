<?php
//turn off deprecicated warnings
error_reporting(E_ALL ^ E_DEPRECATED);
require_once '../config.php';

$dbconnect = NEW DB_Class();
$removeForumPostSql = "UPDATE forum SET status='Offensive' WHERE id = " . $_GET['forumId'];
$removeForumPost = $dbconnect->query($removeForumPostSql);

$selectRemovedMessageSql = "SELECT forum.comment, users.userEmail FROM forum
                            INNER JOIN users ON forum.userId = users.id 
                            WHERE users.id = " . $_GET['userId'] . " AND forum.id = " . $_GET['forumId'];

$selectRemovedMessages = $dbconnect->fetch($selectRemovedMessageSql);

if($removeForumPost) {
foreach($selectRemovedMessages as $selectRemovedMessage) {
//Send email to the forum poster telling them that the post has been removed  
    $to = $selectRemovedMessage['userEmail'];
    $subject = 'A post that you made on the BPeSA Skills portal has been removed.';
    $message = "
    <html>
    <head>
    <title>BPeSA Notification</title>
    </head>
    <body>
    <p>The post that you made on the BPeSA Skills portal has been removed becuase it was deemed offensive of inappropriate.</p>
    <p>If you feel that this is an error please contact us.</p>
    <br />
    <p>'" . $selectRemovedMessage['comment'] . "'</p>
    <table>
    </body>
    </html>";

    // Always set content-type when sending HTML email
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
	mail($to,$subject,$message,$headers);
}
   header( 'Location: '. HOSTNAME. 'admin/' . $_GET['originUrl'] . '.php');   
}
?>

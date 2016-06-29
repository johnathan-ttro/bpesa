<?php
//turn off deprecicated warnings
error_reporting(E_ALL ^ E_DEPRECATED);
$page_title = 'BpeSA skills Portal - Messages';
require_once '../config.php';
require_once '../header.php';
include '../sessionTest.php';

$currentpage = basename($_SERVER['PHP_SELF']); 
$currentpage = substr($currentpage, 0, -4);

$dbconnect = NEW DB_Class();

echo '<h1 class="page-title"><span class="current-page">Inb</span>ox</h1>';

$messageDetailsSql = "SELECT message, 
                             messageRecipientId, 
                             messageSenderId, 
                             messageSubject,
                             realName 
                             FROM  message_table 
                             INNER JOIN users ON message_table.messageRecipientId = users.id 
                             WHERE messageParentId = " . $_GET['id'] ." OR message_table.id = " . $_GET['id']  . "";
$messageDetails = $dbconnect->fetch($messageDetailsSql);

echo '<table class="table1">';

if($messageDetails) {
  $subject = true;
  foreach($messageDetails as $messageDetail) {
     //print the subject once
    if($subject){
      echo '<tr>
              <th colspan="2">' . $messageDetail['messageSubject'] . '</th>
            </tr>';
      $subject = false;
    }
    //show the message Body
    echo '<tr>
            <td>' . $messageDetail['realName'] . '</td>
            <td>' . $messageDetail['message'] . '</td>
          </tr>';


  }
}
echo '</table>
      <td><div id="showFormButton"><h2><span class="selectors text-center">Reply</span></h2></div></td>
      <br>
      <div id="showEmailForm" style="display:none;">
      <form name="replyForm" action="' . HOSTNAME . 'functions/message_send.php" method="post" onsubmit="return validateReplyForm()">
        <textarea name="message"></textarea>
        <input type="hidden" name="subject" value="' . $messageDetail['messageSubject']  . '">
        <input type="hidden" name="senderId" value="' . $messageDetail['messageSenderId'] . '">
        <input type="hidden" name="recipientId" value="' . $messageDetail['messageRecipientId'] . '">
        <input type="hidden" name="parentId" value="' . $_GET['id'] . '">
        <input type="hidden" name="currentPage" value="' . $currentpage . '" > 
        <input type="hidden" name="currentPageType" value="providers" >
        <br/>
        <input type="submit" class="btn btn-primary text-center" value="Send Mail">
      <form>
     </div>
     <br/>';

include '../footer.php';
?>

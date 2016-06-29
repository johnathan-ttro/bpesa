<?php
//turn off deprecicated warnings
error_reporting(E_ALL ^ E_DEPRECATED);
$page_title = 'BpeSA skills Portal - Messages';
require_once '../config.php';
require_once '../header.php';
include '../sessionTest.php';

$currentpage = basename($_SERVER['PHP_SELF']); 
$currentpage = substr($currentpage, 0, -4);

$dbconnect = NEW DB_Class( );
/*
$inboxContentSql = "SELECT pageContent FROM adminPages WHERE pageUrl = '" . $currentpage . "'";
$inboxContent = $dbconnect->getone($inboxContentSql);
*/
$messageListSql = "SELECT 
                   message_table.id AS messageId,
                   message_table.messageRecipientId, 
                   message_table.messageSenderId, 
                   message_table.message, 
                   message_table.messageDate,
                   message_table.messageRead,
                   users.id,
                   users.realName,
                   users.userType
                   FROM message_table 
                   INNER JOIN users ON message_table.messageRecipientId = users.id 
                   WHERE users.id = " . $_SESSION['userId'] . " 
                   AND messageDeleted = 'N'";

$messageLists = $dbconnect->fetch($messageListSql);
//page Content
echo $inboxContent . '<br /><br />';
//message Lists
echo '<table class="table1" >';
if(empty($messageLists)) {
 //There are no emails for this user
 echo '
   <tr>
     <td>You have no new messages</td>
   </tr>';
} else {
  echo '<th>From</th>
        <th>Recieved</th>
        <th>Read</th>
        <th>Delete</th>';
//Loop through the emails and display the list
  foreach($messageLists as $messageList) {
    //get the senders name and if nessecary, company Name.
    $sendersUserTypeSql = "SELECT userType FROM users WHERE id = " . $messageList['messageSenderId'];
    $sendersUserType = $dbconnect->getone($sendersUserTypeSql); 
    if($sendersUserType == 'provider') {
      $sendersNameSql = 'SELECT 
                         providers.companyName
                         FROM users
                         INNER JOIN providers 
                         ON users.id = providers.userID
                         WHERE users.id = ' . $messageList['messageSenderId']  . '';
    } else {
      $sendersNameSql = 'SELECT 
                         realName
                         FROM users
                         WHERE id = ' . $messageList['messageSenderId']  . '';
    }
    $sendersName = $dbconnect->getone($sendersNameSql);
  
    echo '
      <tr>
        <td>
          <a href="' . HOSTNAME . 'users/user_message_detail.php?messageId=' . $messageList['messageId'] . '">
            ' . $sendersName . '
          </a>
        </td>
        <td>' . $messageList['messageDate'] . '</td>';
        //check to see if the message has been read or not
        if($messageList['messageRead'] == 'Y') {
          echo '
            <td>
             <a href="' . HOSTNAME . 'users/user_message_detail.php?messageId=' . $messageList['messageId'] . '">Read
              </a>
            </td>';
        } else {
          echo '
            <td>
              <a href="' . HOSTNAME . 'users/user_message_detail.php?messageId=' . $messageList['messageId'] . '">Unread
              </a>
            </td>';  
        }
      echo'
        <td>
         <a href="' . HOSTNAME . 'functions/user_message_delete.php?messageId=' . $messageList['messageId'] . '&userType=' . $messageList['userType'] . '">
            <img src="' . HOSTNAME . 'images/cross.jpg" width=15px/>
          </a>
        </td>
      </tr>';
  }
}
echo '</table><br>';

include '../footer.php';
?>
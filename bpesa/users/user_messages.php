<?php
//turn off deprecicated warnings
error_reporting(E_ALL ^ E_DEPRECATED);
$page_title = 'BpeSA skills Portal - Messages';
require_once '../config.php';
require_once '../header.php';
include '../sessionTest.php';

$currentpages = basename($_SERVER['PHP_SELF']); 
$currentpages = substr($currentpages, 0, -4);

$dbconnect = NEW DB_Class();
//page Content
echo '<h1 class="page-title"><span class="current-page">Inb</span>ox</h1>';

$inboxContentSql = "SELECT pageContent FROM userpages WHERE pageUrl = '" . $currentpages . "'";
$inboxContent = $dbconnect->getone($inboxContentSql);

$messageListcountSql = "SELECT message_table.id AS messageId,
                               messageRecipientId,
                               messageParentId,
                               messageSenderId, 
                               message,
                               messageSubject, 
                               messageDate,
                               messageRead,
                               users.id,
                               realName,
                               userType
                               FROM message_table 
                               INNER JOIN users ON message_table.messageRecipientId = users.id OR message_table.messageSenderId = users.id 
                               WHERE users.id = " . $_SESSION['userId'] . " AND messageDeleted = 'N' AND messageParentId IS NULL";
$messageListcount = $dbconnect->fetch($messageListcountSql);


//pagination script
$base_url = HOSTNAME;
$per_page = 5;//number of results to shown per page 
$num_links = 8;// how many links you want to show
$total_rows = count($messageListcount); 
$cur_page = 1;// set default current page to 1
  
if(isset($_GET['page'])){
      $cur_page = $_GET['page'];
      $cur_page = ($cur_page < 1)? 1 : $cur_page; //if page no. in url is less then 1 or -ve
}
    
$offset = ($cur_page-1)*$per_page;//setting offset
   
$pages = ceil($total_rows/$per_page);// no of page to be created
$start = (($cur_page - $num_links) > 0) ? ($cur_page - ($num_links - 1)) : 1;
$end   = (($cur_page + $num_links) < $pages) ? ($cur_page + $num_links) : $pages;

$messageListSql = "SELECT message_table.id AS messageId,
                               messageRecipientId, 
                               messageSenderId, 
                               messageParentId,
                               message,
                               messageSubject, 
                               messageDate,
                               messageRead,
                               users.id,
                               realName,
                               userName,
                               userType
                               FROM message_table 
                               INNER JOIN users ON messageRecipientId = users.id OR message_table.messageSenderId = users.id 
                               WHERE users.id = " . $_SESSION['userId'] . " AND messageDeleted = 'N' AND messageParentId IS NULL
                               ORDER BY message_table.id DESC LIMIT " . $per_page ." OFFSET " . $offset . "";
$messageLists = $dbconnect->fetch($messageListSql);

if(empty($messageLists)) {
 //There are no emails for this user
 echo '<h4 class="text-center">You have no new messages</h4>';
} else {

  include '../functions/pagination_navigation.php'; 

  //Loop through the emails and display the list
  echo '<div class="row">
          <div class="col-lg-3 col-md-3">';
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
    echo '<div class="message msg-divide">
            <div style="float:right;margin-top:12px;" >
              <a href="#"><img src="' . HOSTNAME . 'images/unread.png"></a>
              <a href="' . HOSTNAME . 'functions/user_message_delete.php?messageId=' . $messageList['messageId'] . '&userType=' . $messageList['userType'] . '"><img style="margin-left:5px;"  src="' . HOSTNAME . 'images/delete.png"></a>
            </div>
            <h1 class="msg-title"><a href="' . HOSTNAME . 'users/user_messages.php?messageId=' . $messageList['messageId'] . '">' . $messageList['messageSubject'] . '</a></h1>
            <span class="date">' . $messageList['messageDate'] . '</span>
            <h1 class="msg-sender"><span class="msg-user"><a href="' . HOSTNAME . '/users/user_message_detail.php?messageId=' . $messageList['messageId'] . '">' . $sendersName . '</a></span> to me</h1>
          </div>';

  }
  echo '</div>';
  //End of Loop through the emails and display the list
  $messageBoolean = true;
  echo '<div class="col-lg-8 col-md-8">';
  foreach($messageLists as $messageList) { 

    //Get the senders name and if nessecary, company Name.
    if($messageList['messageId'] == $_GET['messageId']){
      echo '<div class="msg-head" style="border-bottom:3px solid #ff6600;padding-bottom:10px; position:relative;margin-top:20px;margin-bottom:15px;">
            <div class="user-image"><img src="' . HOSTNAME . 'images/user.png"> </div>
            <div class="msg-info" style="display:inline; margin-left:20px !important">
              <h1 style="display:inline-block; font-size:24px; margin:0px !important; position:absolute; top:5px">' . $messageList['messageSubject'] . '</h1>
              <h3 style="display:inline-block; font-size:14px; margin:0px ; position:absolute; top:40px">' . $messageList['userName'] . ' to ME</h3>
            </div>
            <div class="msg-actions">
            <a href="' . HOSTNAME . 'functions/user_message_delete.php?messageId=' . $messageList['messageId'] . '&userType=' . $messageList['userType'] . '"><img src="' . HOSTNAME . 'images/trash.png"></a> 
            <a href="' . HOSTNAME . 'users/user_message_detail.php?id=' . $messageList['messageId'] . '"><img style="margin-left:10px;" src="' . HOSTNAME . 'images/forward.png"></a>
            </div>
          </div>
          <div class="msg-content" style="font-size:13px">
          ' . $messageList['message'] . '
           </div>';
      }

      if(empty($_GET['messageId'])){
        if($messageBoolean){
          echo '<div class="msg-head" style="border-bottom:3px solid #ff6600;padding-bottom:10px; position:relative;margin-top:20px;margin-bottom:15px;">
              <div class="user-image"><img src="' . HOSTNAME . 'images/user.png"> </div>
              <div class="msg-info" style="display:inline; margin-left:20px !important">
                <h1 style="display:inline-block; font-size:24px; margin:0px !important; position:absolute; top:5px"><a href="' . HOSTNAME . 'users/user_message_detail.php?messageId=' . $messageList['messageId'] . '">' . $messageList['messageSubject'] . '</a></h1>
                <h3 style="display:inline-block; font-size:14px; margin:0px ; position:absolute; top:40px">' . $messageList['userName'] . ' to ME</h3>
              </div>
              <div class="msg-actions">
              <a href="' . HOSTNAME . 'functions/user_message_delete.php?messageId=' . $messageList['messageId'] . '&userType=' . $messageList['userType'] . '"><img src="' . HOSTNAME . 'images/trash.png"></a> 
              <a href="' . HOSTNAME . 'users/user_message_detail.php?id=' . $messageList['messageId'] . '"><img style="margin-left:10px;" src="' . HOSTNAME . 'images/forward.png"></a>
              </div>
            </div>
            <div class="msg-content" style="font-size:13px">
            ' . $messageList['message'] . '
             </div>';
             $messageBoolean = false;
         } 
      }

      
  }
  echo '</div>';

}

$providersSql = "SELECT providers.id, providers.companyName, providers.contactPerson, providers.email
						FROM providers
						INNER JOIN courses ON courses.id = providers.id
						INNER JOIN user_booking_link ON user_booking_link.courseId = courses.id
						WHERE user_booking_link.userId = " . $_SESSION['userId'] . " GROUP BY providers.id";
$providersDetailLists = $dbconnect->fetch($providersSql);
 
include_once '../footer.php';
?>

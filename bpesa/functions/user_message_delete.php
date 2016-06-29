<?php
//turn off deprecicated warnings
error_reporting(E_ALL ^ E_DEPRECATED);
require_once '../config.php';

if(!empty($_GET['messageId']) && (!empty($_GET['userType']))) {
  $dbconnect = NEW DB_Class();
  $messageDeleteSQL = "UPDATE message_table SET messageDeleted = 'Y' WHERE id = " . $_GET['messageId'];

  $messageDelete = $dbconnect->query($messageDeleteSQL);
  if($messageDelete) {
    if($_GET['userType'] == 'provider') {
      $pageType = 'providers';
    } elseif ($_GET['userType'] == 'users') {
      $pageType = 'users';   
    }
    header( 'Location: '. HOSTNAME. $pageType . '/user_messages.php');
  }
}
?>

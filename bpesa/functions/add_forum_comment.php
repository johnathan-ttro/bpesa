<?php
require_once '../config.php';
//require_once '../header.php';
//include '../sessionTest.php';

$currentPage = $_POST['originUrl'];
$date = date('m/d/Y');

if(!empty($_POST)) {

$dbconnect = NEW DB_Class();

  $addForumCommentSql = "INSERT INTO forum 
                         (userId, comment, dateAdded, topic, status) 
                         VALUES 
                         (" . $_POST['userId'] . ", '" . mysql_real_escape_string($_POST['comment']) . "', '" . $date . "', " . $_POST['topic'] . ", 'Y')";

  $addForumComment = $dbconnect->query($addForumCommentSql);
  
  if($addForumComment) {
    header( 'Location: '. HOSTNAME. $_POST['pageType'] . '/' . $currentPage . '.php');
  }
}

include '../footer.php';
?>
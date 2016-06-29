<?php
error_reporting(E_ALL ^ E_DEPRECATED);
require_once '../config.php';
include '../sessionTest.php';

$dbconnect = NEW DB_Class();

if(!empty($_POST)){
  $currentPage = $_POST['originUrl'];
  $userCompanyProfile = strip_word_html($_POST['userCompanyProfile']);
  $updateUserProfileSql = "UPDATE users 
                           SET 
                           realName='" . $_POST['realName'] . "',
                           userEmail='" . $_POST['userEmail']  . "',
                           userCompany='" . $_POST['userCompany']  . "',
                           userCompanyProfile='" . mysql_real_escape_string($userCompanyProfile)  . "',
                           userCategory='" . $_POST['userCategory']  . "',
                           userContactNumber='" . $_POST['userContactNumber']  . "',
                           userWebsite='" . $_POST['userWebsite']  . "'
                           WHERE id=" . $_SESSION['userId'];
  $updateUserProfile = $dbconnect->query($updateUserProfileSql);
  
  if($updateUserProfile) {
   header( 'Location: '. HOSTNAME. 'vendors/' . $currentPage . '.php');
  }  
}
include '../footer.php';

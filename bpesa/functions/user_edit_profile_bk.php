<?php
//turn off deprecicated warnings
error_reporting(E_ALL ^ E_DEPRECATED);
require_once '../config.php';
include '../sessionTest.php';

$dbconnect = NEW DB_Class();

if(!empty($_POST)){
  $currentPage = $_POST['originUrl'];
  $companyProfile = strip_word_html($_POST['userCompanyProfile'], '<b><i><sup><sub><em><strong><u><br><br /><p></p>');
  $updateUserProfileSql = "UPDATE users 
                           SET 
                           userName='" . $_POST['userName'] . "',
                           realName='" . $_POST['realName'] . "',
                           userEmail='" . $_POST['userEmail']  . "',
                           userCompany='" . $_POST['userCompany']  . "',
                           userCompanyProfile='" . mysql_real_escape_string($companyProfile)  . "',
                           userCategory='" . $_POST['userCategory']  . "',
                           userContactNumber='" . $_POST['userContactNumber']  . "',
                           userWebsite='" . $_POST['userWebsite']  . "'
                           WHERE id=" . $_SESSION['userId'];
  $updateUserProfile = $dbconnect->query($updateUserProfileSql);
  
  if($updateUserProfile) {
   header( 'Location: '. HOSTNAME. 'users/' . $currentPage . '.php');
  }  
}
?>

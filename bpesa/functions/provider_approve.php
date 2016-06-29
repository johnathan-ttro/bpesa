<?php
//turn off deprecicated warnings
error_reporting(E_ALL ^ E_DEPRECATED);
require_once '../config.php';

$currentPage = $_GET['originUrl'];

if(!empty($_GET)) {

$dbconnect = NEW DB_Class();

    if($_GET['procedure'] == 'active') {
      if($_GET['status'] == 'Y') {
        $updateProviderStatusSql = 'UPDATE providers SET active="N" WHERE id = ' . $_GET['providerId'];
        $updateUserTableStatusSql = 'UPDATE users SET active="N" where id = ' . $_GET['userId'];
      } elseif($_GET['status'] == 'N') {
         $updateProviderStatusSql = 'UPDATE providers SET active="Y" WHERE id = ' . $_GET['providerId'];
          $updateUserTableStatusSql = 'UPDATE users SET active="N" where id = ' . $_GET['userId'];
      } else {
        exit('There was a problem with the status of the user. No indication of the users staus was initialised.');
      }
    } 
    if($_GET['procedure'] == 'approved') {
      if($_GET['status'] == 'Y') {
        $updateProviderStatusSql = 'UPDATE providers SET approved="N" WHERE id = ' . $_GET['providerId'];
        $updateUserTableStatusSql = 'UPDATE users SET active="N" where id = ' . $_GET['userId'];
      } elseif($_GET['status'] == 'N') {
         $updateProviderStatusSql = 'UPDATE providers SET approved="Y" WHERE id = ' . $_GET['providerId'];  
         $updateUserTableStatusSql = 'UPDATE users SET active="Y" where id = ' . $_GET['userId'];
      } else {
        exit('There was a problem with the status of the user. No indication of the users staus was initialised.');
      }
    } 
    $updateUserTableStatus = $dbconnect->query($updateUserTableStatusSql);
    $updateProviderStatusSave = $dbconnect->query($updateProviderStatusSql);
    if($updateProviderStatusSave) {
       header( 'Location: '. HOSTNAME. 'admin/' . $currentPage . '.php');
    }
} else {
     exit('no posted data');
}
?>

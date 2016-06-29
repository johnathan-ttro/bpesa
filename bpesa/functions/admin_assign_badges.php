<?php
//turn off deprecicated warnings
error_reporting(E_ALL ^ E_DEPRECATED);
require_once '../config.php';

$currentPage = $_POST['originUrl'];

$dbconnect = NEW DB_Class();

if(!empty($_POST)) {
    if(!empty($_POST['vendorId'])){
      if($_POST['badge'] == 'Y') {
        $updateVendorStatusSql = 'UPDATE vendors SET badge="N" WHERE id = ' . $_POST['vendorId'];
      } elseif($_POST['badge'] == 'N') {
        $updateVendorStatusSql = 'UPDATE vendors SET badge="Y" WHERE id = ' . $_POST['vendorId'];
      } else {
        exit('There was a problem with the status of the user. No indication of the users staus was initialised.');
      }

      $updateVendorStatusSave = $dbconnect->query($updateVendorStatusSql);

      if($updateVendorStatusSave) {
         header( 'Location: '. HOSTNAME. 'vendors/' . $currentPage . '.php');
      }
    }

  if(!empty($_POST['providerId'])){
    if($_POST['badge'] == 'Y') {
      $updateProviderStatusSql = 'UPDATE providers SET badge="N" WHERE userID = ' . $_POST['providerId'];
    } elseif($_POST['badge'] == 'N') {
      $updateProviderStatusSql = 'UPDATE providers SET badge="Y" WHERE userID = ' . $_POST['providerId'];
    } else {
      exit('There was a problem with the status of the user. No indication of the users staus was initialised.');
    }

    $updateProviderStatusSave = $dbconnect->query($updateProviderStatusSql);

    if($updateProviderStatusSave) {
       header( 'Location: '. HOSTNAME. 'providers/' . $currentPage . '.php');
    }
  }  
} else {
     exit('no posted data');
}

?>

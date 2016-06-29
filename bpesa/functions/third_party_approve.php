<?php
//turn off deprecicated warnings
error_reporting(E_ALL ^ E_DEPRECATED);
require_once '../config.php';

$currentPage = $_GET['originUrl'];

if(!empty($_GET)) {

$dbconnect = NEW DB_Class();
    if($_GET['status'] == 'Y') {
      $updateVendorStatusSql = 'UPDATE vendors SET active="N" WHERE id = ' . $_GET['thirdPartyId'];
    } elseif($_GET['status'] == 'N') {
      $updateVendorStatusSql = 'UPDATE vendors SET active="Y" WHERE id = ' . $_GET['thirdPartyId'];  
    } else {
      exit('There was a problem with the status of the user. No indication of the users status was initialised.');
    }
     
    $updateVendorStatusSave = $dbconnect->query($updateVendorStatusSql);
    if($updateVendorStatusSave) {
       header( 'Location: '. HOSTNAME. 'admin/' . $currentPage . '.php');
    }
} else {
     exit('no posted data');
}
?>
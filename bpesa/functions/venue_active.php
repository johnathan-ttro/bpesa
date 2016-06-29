<?php
error_reporting(E_ALL ^ E_DEPRECATED);
require_once '../config.php';

$currentPage = $_GET['originUrl'];

$dbconnect = NEW DB_Class();
if($_GET['status'] == "Y") {
  $updateVendorStatusSql = 'UPDATE vendors SET active="N" WHERE id = ' . $_GET['vendorId'];
} else {
  $updateVendorStatusSql = 'UPDATE vendors SET active="Y" WHERE id = ' . $_GET['vendorId'];   
}

$updateVendorStatus = $dbconnect->query($updateVendorStatusSql);

if($updateVendorStatus) {
  header( 'Location: '. HOSTNAME . 'providers/' . $currentPage . '.php');
}
?>

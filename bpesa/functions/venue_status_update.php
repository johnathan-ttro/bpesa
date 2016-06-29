<?php
error_reporting(E_ALL ^ E_DEPRECATED);
require_once '../config.php';
include '../sessionTest.php';

$currentPage = $_GET['originUrl'];

$dbconnect = NEW DB_Class();

$status = $_GET['active'];
if($status == 'Y') {
  $status = 'N';
} else {
  $status = 'Y';
}
$updateVenueStatusSql = 'UPDATE vendors SET active="' . $status . '" WHERE id = ' . $_GET['venueId'];
$updateVenueStatus = $dbconnect->query($updateVenueStatusSql);

  if($updateVenueStatus) {
    header( 'Location: '. HOSTNAME. 'vendors/' . $currentPage . '.php');
  }
?>

<?php
error_reporting(E_ALL ^ E_DEPRECATED);
require_once '../config.php';
//require_once '../header.php';
$currentPage = $_POST['originUrl'];

if(!empty($_POST)) {

  $dbconnect = NEW DB_Class();
  $venueAddress = strip_word_html($_POST['venueAddress']);
  $addVenueSql = "INSERT INTO vendors (userId, vendorName, vendorEmail, vendorTel, vendorLocation, vendorAddress, province, vendorCapacity,  roomNumber, floor, projectorProvided, refreshmentAvailable, additionalInformation, active)
                  VALUES ('" . $_POST['userId'] . "',
                          '" . $_POST['venueName'] . "',
                          '" . $_POST['venueEmail'] . "',
                          '" . $_POST['venueTel'] . "',
                          '" . $_POST['venueLocation'] . "',
                          '" . mysql_real_escape_string($venueAddress) . "',
                          '" . $_POST['province'] . "',
                          '" . $_POST['venueCapacity'] . "',
                          '" . $_POST['roomNumber'] . "',
                          '" . $_POST['floor'] . "',
                          '" . $_POST['projectorProvided'] . "',
                          '" . $_POST['refreshmentAvailable'] . "',
                          '" . $_POST['additionalInformation']. "',
                          'N')";
  
  $addVenue = $dbconnect->query($addVenueSql);

  $breaks = $_POST['breaks'];

  foreach ($breaks as $break){
    $addBreaksSql = "INSERT INTO vendors (userId, breakId) VALUES ('" . $_POST['userId'] ." ', '" . $break ."')";
    $addBreak = $dbconnect->query($addBreaksSql);
  }

  if($addVenue) {
    header( 'Location: '. HOSTNAME . 'providers/' . $currentPage . '.php');
  }
}
?>

<?php
error_reporting(E_ALL ^ E_DEPRECATED);
require_once '../config.php';
$currentPage = $_POST['originUrl'];

if(!empty($_POST)) {

  $dbconnect = NEW DB_Class();

  $venueAddress = strip_word_html($_POST['venueAddress']);
  $addVenueSql = "INSERT INTO vendors (userId, vendorName, vendorEmail, vendorTel, vendorLocation, vendorAddress, vendorCapacity, active)
                  VALUES ('" . $_POST['userId'] . "',
                          '" . $_POST['venueName'] . "',
                          '" . $_POST['venueEmail'] . "',
                          '" . $_POST['venueTel'] . "',
                          '" . $_POST['venueLocation'] . "',
                          '" . mysql_real_escape_string($venueAddress) . "',
                          '" . $_POST['venueCapacity'] . "',
                          'N')";
  
  $addVenue = $dbconnect->query($addVenueSql);
  if($addVenue) {
    header( 'Location: '. HOSTNAME . 'operators/' . $currentPage . '.php');
  }
}
?>

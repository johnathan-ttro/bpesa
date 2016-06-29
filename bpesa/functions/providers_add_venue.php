<?php
error_reporting(E_ALL ^ E_DEPRECATED);
require_once '../config.php';

$currentPage = $_POST['originUrl'];

$dbconnect = NEW DB_Class();

if(isset($_POST['submit'])) {
  $addNewVenueSql = 'INSERT INTO vendors 
                     (userId, vendorName, vendorEmail, vendorTel, province, vendorLocation, vendorAddress, vendorCapacity, roomNumber, floor, projectorProvided, refreshmentAvailable, additionalInformation, active)
                     VALUES 
                     ('  . $_SESSION['userId'] . ',
                      "' . $_POST['vendorName'] . '",
                      "' . $_POST['vendorEmail'] . '",
                      "' . $_POST['vendorTel'] . '",
                      "' . $_POST['province']. '",
                      "' . $_POST['vendorLocation']. '",
                      "' . $_POST['vendorAddress']. '",
                      "' . $_POST['vendorCapacity']. '",
                      "' . $_POST['roomNumber']. '",
                      "' . $_POST['floor']. '",
                      "' . $_POST['projectorProvided']. '",
                      "' . $_POST['refreshmentAvailable']. '",
                      "' . $_POST['additionalInformation']. '",
                      "Y")';
  $addNewVenue = $dbconnect->query($addNewVenueSql);

  $getvendorIdSql= "SELECT MAX(id) FROM vendors WHERE userId = " . $_SESSION['userId']  ;
  $getvendorId = $dbconnect->getone($getvendorIdSql);

  
 $breaks = $_POST['break'];

  if(isset($_POST['break'])){
    foreach($breaks as $breakName){
      $insertBreaksSql = "INSERT INTO breaks(vendorId, breakName) VALUES (" . $getvendorId . ",'" . $breakName . "')";
      $insertBreak = $dbconnect->query($insertBreaksSql);
    } 
  }
     
  if($addNewVenue) {
    header( 'Location: '. HOSTNAME. 'providers/' . $currentPage . '.php');
  }
  
}

if(isset($_POST['updateVenues'])) {
  $updateVenueSql = 'UPDATE vendors SET 
                     vendorName="' . $_POST['vendorName'] . '",
                     vendorEmail="' . $_POST['vendorEmail'] . '",
                     vendorTel="' . $_POST['vendorTel'] . '",
                     province="' . $_POST['province'] . '",
                     vendorLocation="' . $_POST['vendorLocation'] . '",
                     vendorAddress="' . $_POST['vendorAddress'] . '",
                     vendorCapacity="' . $_POST['vendorCapacity'] . '",
                     roomNumber="' . $_POST['roomNumber'] . '",
                     floor="' . $_POST['floor'] . '",
                     projectorProvided="' . $_POST['projectorProvided'] . '",
                     refreshmentAvailable="' . $_POST['refreshmentAvailable'] . '",
                     additionalInformation="' . $_POST['additionalInformation'] .'"
                     WHERE id =' . $_POST['venueId'];
  
  $updateVenue = $dbconnect->query($updateVenueSql);

  if($updateVenue) {
    header( 'Location: '. HOSTNAME. 'providers/' . $currentPage . '.php?vendorId=' . $_POST['venueId'] . '');
  }
} 
?>

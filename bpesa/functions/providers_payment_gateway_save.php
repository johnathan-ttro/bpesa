<?php
error_reporting(E_ALL ^ E_DEPRECATED);
require_once '../config.php';

$currentPage = $_POST['originUrl'];

$dbconnect = NEW DB_Class();

if(isset($_POST['newGateway'])) {
  $addGatewayDetailsSql = 'INSERT INTO provider_payment_gateway (providerId, merchantId, merchantKey)
                           VALUES (' . $_POST['userId'] . ', ' . $_POST['merchantId'] . ', "' . $_POST['merchantKey'] . '")';
  
  $addGatewayDetails = $dbconnect->query($addGatewayDetailsSql);
  
  if($addGatewayDetails) {
    header( 'Location: '. HOSTNAME . 'providers/' . $currentPage . '.php?success=Sav');
  }
} elseif (isset($_POST['updateGateway'])){
  $updateGatewaySql = 'UPDATE provider_payment_gateway SET merchantId=' . $_POST['merchantId'] . ', merchantKey="' . $_POST['merchantKey'] . '"
                       WHERE providerId = ' . $_POST['userId'];
  $updateGateway = $dbconnect->query($updateGatewaySql);
    
  if($updateGateway) {
    header( 'Location: '. HOSTNAME . 'providers/' . $currentPage . '.php?success=Sav');
  }
}
?>

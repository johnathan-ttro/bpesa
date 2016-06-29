<?php
error_reporting(E_ALL ^ E_DEPRECATED);
$page_title = 'BpeSA skills Portal - Payment Gateaway';
require_once '../config.php';
require_once '../header.php';
include '../sessionTest.php';

$currentpage = basename($_SERVER['PHP_SELF']); 
$currentpage = substr($currentpage, 0, -4);

$paymentGatewayContentSql = "SELECT pageContent FROM providerpages WHERE pageUrl = '" . $currentpage . "'";
$paymentGatewayContent = $dbconnect->getone($paymentGatewayContentSql);

$gatewayExistsChecksSql = 'SELECT providerId, merchantId, merchantKey FROM provider_payment_gateway WHERE providerId =' . $_SESSION['userId'];
$gatewayExistsChecks = $dbconnect->fetch($gatewayExistsChecksSql);

echo $paymentGatewayContent;

if($_GET['success'] != 'Sav') {
  echo '
  <h1 class="page-title"><span class="current-page">Pay</span>ment Gateway details</h1>
  <div class="container">
   <div class="row">
      <div class="col-lg-6 col-md-6 col-md-12 col-xs-12">
  <form name="paymentgatewayForm" action="' . HOSTNAME . 'functions/providers_payment_gateway_save.php" method="post" onsubmit="return validatePaymentGatewayForm()" >
  <table  class="table">
    <tr>
      <td><label class="text-info">Merchant ID</label></td>
      <td>
          <input type="text" class="form-control" name="merchantId">
          <input type="hidden" value="' . $_SESSION['userId'] . '" name="userId">
          <input type="hidden" name="originUrl" value="' . $currentpage . '">
      </td>
    </tr>
    <tr>
      <td><label class="text-info">Merchant Key</label></td>
      <td><input type="text" class="form-control" name="merchantKey"></td>
    </tr>
    <tr>
      <td><input type="submit" class="btn btn-primary" name="newGateway" value="submit"></td>
      <td>&nbsp;</td>
    </tr>
  </table>
  </div>
  </div>
  </div>';
} else {
  foreach($gatewayExistsChecks as $gatewayExistsCheck) {
  echo 'Your Payment Gateway Details have been loaded.<br />
        Would you like to update your details?
     <div class="row">
      <div class="col-lg-6 col-md-6 col-md-12 col-xs-12">
    <form action="' . HOSTNAME . 'functions/providers_payment_gateway_save.php" method="post">
    <table class="table">
      <tr>
        <td><label class="text-info">Merchant Id</label></td>
        <td>
          <input type="text" class="form-control" value="' . $gatewayExistsCheck['merchantId'] . '" name="merchantId">
          <input type="hidden" value="' . $_SESSION['userId'] . '" name="userId">
          <input type="hidden" name="originUrl" value="' . $currentpage . '">
        </td>
      </tr>
      <tr>
        <td><label class="text-info">Merchant Key</label></td>
        <td><input type="text" class="form-control" value="' . $gatewayExistsCheck['merchantKey'] . '" name="merchantKey"></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><input type="submit" class="btn btn-primary" name="updateGateway" value="submit"></td>
      </tr>
    </table></div>
    </div>
    </div>';
  }
}

include '../footer.php';
?>

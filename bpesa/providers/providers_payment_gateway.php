<?php
error_reporting(E_ALL ^ E_DEPRECATED);
$page_title = 'BpeSA skills Portal - Payment Gateway';
require_once '../config.php';
require_once '../header.php';

$currentpage = basename($_SERVER['PHP_SELF']); 
$currentpage = substr($currentpage, 0, -4);

$paymentGatewayContentSql = "SELECT pageContent FROM providerpages WHERE pageUrl = '" . $currentpage . "'";
$paymentGatewayContent = $dbconnect->getone($paymentGatewayContentSql);

$gatewayExistsChecksSql = 'SELECT providerId, merchantId, merchantKey FROM provider_payment_gateway WHERE providerId =' . $_SESSION['userId'];
$gatewayExistsChecks = $dbconnect->fetch($gatewayExistsChecksSql);

echo '<h1 class="page-title"><span class="current-page">Pay</span>ment Gateway</h1>
<div class="col-lg-6 col-lg-offset-1 col-md-6 col-md-12 col-xs-12">';
echo $paymentGatewayContent;

if($_GET['success'] != 'Sav') {
  echo '
  <br />
  <h3>Payment Gateway details</h3>
  <br />
  <form action="' . HOSTNAME . 'functions/providers_payment_gateway_save.php" method="post">
  <table class="table">
    <tr>
      <td>Merchant ID</td>
      <td><input type="text" class="form-control" name="merchantId">
	  <input type="hidden" value="' . $_SESSION['userId'] . '" name="userId">
	  <input type="hidden" name="originUrl" value="' . $currentpage . '">
	  </td>
    </tr>
    <tr>
      <td>Merchant Key</td>
      <td><input type="text" class="form-control" class="form-control"name="merchantKey"></td>
    </tr>
    <tr>
      <td><input type="submit" class="btn btn-primary" name="newGateway" value="Submit"></td>
      <td>&nbsp;</td>
    </tr>
  </table>
  <br>
  <br>';
} else {
  foreach($gatewayExistsChecks as $gatewayExistsCheck) {
  echo '<br />
        <br />
        Your Payment Gateway Details have been loaded.<br />
        Would you like to update your details?
        <br />
        <br />
    <form action="' . HOSTNAME . 'functions/providers_payment_gateway_save.php" method="post">
    <table class="table">
      <tr>
        <td>Merchant Id</td>
        <td><input type="text" class="form-control" value="' . $gatewayExistsCheck['merchantId'] . '" name="merchantId">
			<input type="hidden" value="' . $_SESSION['userId'] . '" name="userId">
			<input type="hidden" name="originUrl" value="' . $currentpage . '">
		</td>
      </tr>
      <tr>
        <td>Merchant Key</td>
        <td><input type="text" class="form-control" value="' . $gatewayExistsCheck['merchantKey'] . '" name="merchantKey"></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><input type="submit" class="btn btn-primary" name="updateGateway" value="submit"></td>
      </tr>
    </table>
    <br>
    <br>';
  }
}
echo "</div>";
include '../footer.php';
?>

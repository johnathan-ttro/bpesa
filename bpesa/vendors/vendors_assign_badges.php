<?php
error_reporting(E_ALL ^ E_DEPRECATED);
require_once '../config.php';
require_once '../header.php';

$currentpage = basename($_SERVER['PHP_SELF']); 
$currentpage = substr($currentpage, 0, -4);

$getVendorListsSql = 'SELECT id, vendorName, vendorEmail, vendorTel, vendorLocation, vendorAddress, badge, vendorCapacity FROM vendors';

$getVendorLists = $dbconnect->fetch($getVendorListsSql);

if($getVendorLists) {
  echo '
  <h2>Vendors</h2>
   <p style="margin:0">Click the radio button in the "Assign Badge" column, to mark the vendor as a trusted one.</p>
  <br/>
  <table class="table1">
    <th>Venue Name</th>
    <th>Email</th>
    <th>Telephone</th>
    <th>Location</th>
    <th>Address</th>
    <th>Capacity</th>
    <th>Assign Badge</th>
    <th>Badge Holder</th>
    ';
  foreach($getVendorLists as $getVendorList) {      
    if($getVendorList['badge'] == "Y") {
        $active = '<img src="' . HOSTNAME . '/images/active.jpg" width="15px" />';
        $color = "red";
    } else {
        $active = '<img src="' . HOSTNAME . '/images/non_active.jpg" width="15px" />';
        $color = "green";
    }
    echo '
      <tr>
        <td>' . $getVendorList['vendorName'] . '</td>
        <td>' . $getVendorList['vendorEmail'] . '</td>
        <td>' . $getVendorList['vendorTel'] . '</td>
        <td>' . $getVendorList['vendorLocation'] . '</td>
        <td>' . $getVendorList['vendorAddress'] . '</td>
        <td style="text-align:center">' . $getVendorList['vendorCapacity'] . '</td>
        <td align="center">
        <form action="' . HOSTNAME . 'functions/admin_assign_badges.php" method="post">
            <input type="radio" name="vendorId" value="' . $getVendorList['id'] . '" onclick="this.form.submit();" >
            <input type="hidden" name="badge" value="' . $getVendorList['badge'] . '" >
            <input type="hidden" name="originUrl" value="' . $currentpage . '">
        </form>
        </td>
        <td style="text-align:center">
           ' . $active . ' 
        </td>
      </tr>';
  }
  echo '
  </table>
  <br/>';
}

include '../footer.php';
?>

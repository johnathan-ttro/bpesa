<?php
error_reporting(E_ALL ^ E_DEPRECATED);
$page_title = 'BpeSA skills Portal - Update Venues';
require_once '../config.php';
require_once '../header.php';
include '../sessionTest.php';

$currentpage = basename($_SERVER['PHP_SELF']); 
$currentpage = substr($currentpage, 0, -4);

$regionNamesSql = "SELECT id, regionNames FROM regions";
$regionNamesOptions = $dbconnect->fetch($regionNamesSql);

$currentVenueSql = 'SELECT 
                    id,
                    vendorName, 
                    vendorEmail, 
                    vendorTel, 
                    vendorLocation, 
                    vendorAddress,
                    vendorCapacity,
                    roomNumber,
                    floor,
                    province,
                    projectorProvided,
                    refreshmentAvailable,
                    additionalInformation,
                    active
                    FROM vendors
                    WHERE id = ' . $_GET['venueId'];

$currentVenues = $dbconnect->fetch($currentVenueSql);

echo '
<h1 class="page-title"><span class="current-page">Upd</span>ate Venues</h1>
  <div class="col-lg-6 col-lg-offset-1 col-md-6 col-md-12 col-xs-12">
  
	<form action="' . HOSTNAME . 'functions/vendor_add_venue.php" method="post">
		<table class="table">';
if($currentVenues) {
  foreach($currentVenues as $currentVenue) {

    $projectorProvided = $currentVenue['projectorProvided'];
    $selectedprojectorY = false;
    $selectedprojectorN = false;

    if($projectorProvided == "Y"){
      $selectedprojectorY = ' checked = "checked"';
    }
    if($projectorProvided == "N"){
      $selectedprojectorN = ' checked = "checked"';
    } 

    $refreshmentAvailable = $currentVenue['refreshmentAvailable'];

    $selectedAvailablerefreshmentY = false;
    $selectedAvailablerefreshmentN = false;

    if($refreshmentAvailable == "Y"){
      $selectedAvailablerefreshmentY = ' checked = "checked"';
    }
    if($refreshmentAvailable == "N"){
      $selectedAvailablerefreshmentN = ' checked = "checked"';
    }

    $currentBreakSql = 'SELECT id, breakName FROM breaks WHERE vendorId = ' . $_GET['venueId'];
    $currentBreakLists = $dbconnect->fetch($currentBreakSql);

    foreach($currentBreakLists as $currentBreakList){
      if($currentBreakList['breakName'] == "breakfast"){
        $checkedbreakfast = " checked";
      } 
      if($currentBreakList['breakName'] == "tea"){
        $checkedtea = " checked";
      }
      if($currentBreakList['breakName'] == "lunch"){
        $checkedlunch = " checked";
      }
    }

    echo '     
        <tr>
          <td><label class="text-info">Vendor Name</label></td>
          <td>
            <input type="hidden" name="userId" value="' . $_SESSION['userId'] . '" >
            <input type="hidden" name="originUrl" value="' . $currentpage . '" >
            <input type="hidden" name="venueId" value="' . $currentVenue['id'] . '" >
            <input type="hidden" name="originUrl" value="' . $currentpage . '" >
            <input type="text" class="form-control" name="vendorName" value="' . $currentVenue['vendorName'] . '">
          </td>
        </tr>
        <tr>
          <td><label class="text-info">Vendor Email</label></td>
          <td><input type="text" class="form-control" name="vendorEmail" value="' . $currentVenue['vendorEmail'] . '"></td>
        </tr>
        <tr>
          <td><label class="text-info">Vendor Telephone</label></td>
          <td><input type="text" class="form-control" name="vendorTel" value="' . $currentVenue['vendorTel'] . '"></td>
        </tr>
        <tr>
            <td><label class="text-info">Select Province</label></td> 
            <td>';

          echo '<div style="float:left;" id="selectDiv">
                <select name="province">
                  <option value="N/A" selected>Select One</option>';
                foreach($regionNamesOptions as $regionNamesOption) {
                  if($regionNamesOption['regionNames'] == $currentVenue['province']){
                    echo '<option value="' . $regionNamesOption['regionNames'] . '" selected>' . $regionNamesOption['regionNames'] . '</option>';  
                  }else{
                    echo '<option value="' . $regionNamesOption['regionNames'] . '">' . $regionNamesOption['regionNames'] . '</option>';  
                  } 
                }
          echo '</select>
                </div>'; 

          echo '</td>    
        </tr>
        <tr>
          <td><label class="text-info">Location</label></td>
          <td><input type="text" class="form-control" name="vendorLocation" value="' . $currentVenue['vendorLocation'] . '"></td>
        </tr>
        <tr>
          <td><label class="text-info">Address</label></td>
          <td style="padding:10px 0;"><textarea name="vendorAddress">' . $currentVenue['vendorAddress'] . '</textarea></td>
        </tr>
        <tr>
          <td><label class="text-info">Capacity</label></td>
          <td><input type="text" class="form-control" name="vendorCapacity" value="' . $currentVenue['vendorCapacity'] . '"></td>
        </tr>
        <tr>
          <td><label class="text-info">Room</label></td>
          <td><input type="text" class="form-control" name="roomNumber" value="' . $currentVenue['roomNumber'] . '"></td>
        </tr>
        <tr>
          <td><label class="text-info">Floor</label></td>
          <td><input type="text" class="form-control" name="floor" value="' . $currentVenue['floor'] . '"></td>
        </tr>
        <tr>
          <td><label class="text-info">Projector Provided</label></td>
          <td style="padding:10px 0;">
          <input type="radio" name="projectorProvided" value="Y" ' . $selectedprojectorY . ' > Yes
          <input type="radio" name="projectorProvided" value="N" ' . $selectedprojectorN . ' > No
          </td>
        </tr>
        <tr>
          <td><label class="text-info">Refreshments available</label></td>
          <td>
          <input type="radio" name="refreshmentAvailable" value="Y" '. $selectedAvailablerefreshmentY . '> Yes
          <input type="radio" name="refreshmentAvailable" value="N" ' . $selectedAvailablerefreshmentN . '> No
          </td>
        </tr>
        <tr>
          <td><label class="text-info">Breaks</label></td>
          <td style="padding:10px 0;">
            Breakfast <input type="checkbox" name="break[]" value="breakfast" '. $checkedbreakfast . ' >
            Tea <input type="checkbox" name="break[]" value="tea" '. $checkedtea . ' >
            Lunch <input type="checkbox" name="break[]" value="lunch" '. $checkedlunch . ' >
          </td>
        </tr>
        <tr>
          <td><label class="text-info">Additional information</label></td>
          <td style="padding:10px 0;"><textarea name="additionalInformation"> ' . $currentVenue['additionalInformation'] . '</textarea></td>
        </tr>
        <tr>
          <td><input type="submit"  class="btn btn-primary" name="updateVenues" value="Update Venue"></td>
          <td></td>
        </tr>';
  }
}
echo '</table>
</form>  
<form action="' . HOSTNAME . 'vendors/vendors_venues.php" method="post">
<table class="table">
	<tr><td><input type="submit" class="btn btn-primary" name="back" value="Back"></td></tr>
</table>
</form>  
</div>';

include '../footer.php';
?>

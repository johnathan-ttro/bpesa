<?php
error_reporting(E_ALL ^ E_DEPRECATED);
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
                    province,
                    vendorLocation, 
                    vendorAddress,
                    vendorCapacity,
                    roomNumber,
                    floor,
                    projectorProvided,
                    refreshmentAvailable,
                    additionalInformation,
                    active
                    FROM vendors
                    WHERE id = ' . $_GET['vendorId'];

$currentVenues = $dbconnect->fetch($currentVenueSql);

echo '<table width="600px" cellspacing="0" cellpadding="0" id="form2">
         <form action="' . HOSTNAME . 'functions/providers_add_venue.php" method="post">';
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

    $currentBreakSql = 'SELECT id, breakName FROM breaks WHERE vendorId = ' . $_GET['vendorId'];
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
          <td>Vendor Name</td>
          <td>
            <input type="hidden" name="userId" value="' . $_SESSION['userId'] . '" >
            <input type="hidden" name="originUrl" value="' . $currentpage . '" >
            <input type="hidden" name="venueId" value="' . $currentVenue['id'] . '" >
            <input type="hidden" name="originUrl" value="' . $currentpage . '" >
            <input type="text" name="vendorName" value="' . $currentVenue['vendorName'] . '">
          </td>
        </tr>
        <tr>
          <td>Vendor Email</td>
          <td><input type="text" name="vendorEmail" value="' . $currentVenue['vendorEmail'] . '"></td>
        </tr>
        <tr>
          <td>Vendor Telephone</td>
          <td><input type="text" name="vendorTel" value="' . $currentVenue['vendorTel'] . '"></td>
        </tr>
        <tr>
            <td>Select Province</td> 
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
          <td>Location</td>
          <td><input type="text" name="vendorLocation" value="' . $currentVenue['vendorLocation'] . '"></td>
        </tr>
        <tr>
          <td>Address</td>
          <td style="padding:10px 0;"><textarea name="vendorAddress">' . $currentVenue['vendorAddress'] . '</textarea></td>
        </tr>
        <tr>
          <td>Capacity</td>
          <td><input type="text" name="vendorCapacity" value="' . $currentVenue['vendorCapacity'] . '"></td>
        </tr>
        <tr>
          <td>Room</td>
          <td><input type="text" name="roomNumber" value="' . $currentVenue['roomNumber'] . '"></td>
        </tr>
        <tr>
          <td>Floor</td>
          <td><input type="text" name="floor" value="' . $currentVenue['floor'] . '"></td>
        </tr>
        <tr>
          <td>Projector Provided</td>
          <td style="padding:10px 0;">
          <input type="radio" name="projectorProvided" value="Y" ' . $selectedprojectorY . ' > Yes
          <input type="radio" name="projectorProvided" value="N" ' . $selectedprojectorN . ' > No
          </td>
        </tr>
        <tr>
          <td>Refreshments available</td>
          <td>
          <input type="radio" name="refreshmentAvailable" value="Y" '. $selectedAvailablerefreshmentY . '> Yes
          <input type="radio" name="refreshmentAvailable" value="N" ' . $selectedAvailablerefreshmentN . '> No
          </td>
        </tr>
        <tr>
          <td>Breaks</td>
          <td style="padding:10px 0;">
            Breakfast <input type="checkbox" name="break[]" value="breakfast" '. $checkedbreakfast . ' >
            Tea <input type="checkbox" name="break[]" value="tea" '. $checkedtea . ' >
            Lunch <input type="checkbox" name="break[]" value="lunch" '. $checkedlunch . ' >
          </span>
          </td>
        </tr>
        <tr>
          <td>Additional information</td>
          <td style="padding:10px 0;"><textarea name="additionalInformation"> ' . $currentVenue['additionalInformation'] . '</textarea></td>
        </tr>
        <tr>
          <td><input type="submit" name="updateVenues" class="submit" value="Update Venue"></td>
          <td>&nbsp;</td>
        </tr>';
  }
}
echo '</table>    
    </form>
    <br/>';
include '../footer.php';
?>

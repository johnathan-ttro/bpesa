<?php
error_reporting(E_ALL ^ E_DEPRECATED);
require_once '../config.php';
require_once '../header.php';
include '../sessionTest.php';

$currentpage = basename($_SERVER['PHP_SELF']); 
$currentpage = substr($currentpage, 0, -4);

$regionNamesSql = "SELECT id, regionNames FROM regions";
$regionNamesOptions = $dbconnect->fetch($regionNamesSql);

echo '
  <h4>Add A Venue</h4>
  <form action="' . HOSTNAME . 'functions/providers_venue_save.php" method="post" id="providerAddVenue" name="providerAddVenue"  onsubmit="return validateForm8()" >
    <table width="600px" style="margin-bottom:10px;" id="form2">
      <tr>
        <td>Venue name</td>
        <td><input name="venueName" type="text" /></td>
            <input type="hidden" name="userId" value="' . $_SESSION['userId'] . '" />
            <input type="hidden" name="originUrl" value="providers_venues" />
      </tr>
      <tr>
        <td>Email Address</td>
        <td>
          <input name="venueEmail" type="text" />
          <div class="hover" style="left:228px; top:-35px;"><img src="' . HOSTNAME . 'images/icon.png">
            <div class="tooltip">The email that is used to communicate with the venue.</div>
          </div>
        </td>
      </tr>
      <tr>
        <td>Telephone</td>
        <td>
          <input name="venueTel" type="text" />
          <div class="hover" style="left:228px; top:-35px;"><img src="' . HOSTNAME . 'images/icon.png">
            <div class="tooltip">The contact number for the the venue.</div>
          </div>
        </td>
      </tr>
      <tr>
        <td>Province</td> 
        <td>';
echo    '<div style="float:left;" id="selectDiv">
          <select id="province" name="province">
            <option value="N/A" selected>Select One</option>';
          foreach($regionNamesOptions as $regionNamesOption) {
              echo '<option value="' . $regionNamesOption['regionNames'] . '">' . $regionNamesOption['regionNames'] . '</option>';  
          }
echo     '</select>
          </div>'; 
echo '</td>    
    </tr>
      <tr>
        <td>Location</td>
        <td>
          <input name="venueLocation" type="text" />
          <div class="hover" style="left:228px; top:-35px;"><img src="' . HOSTNAME . 'images/icon.png">
            <div class="tooltip">The city or town where the venue is located.</div>
          </div>
        </td>
      </tr>
      <tr>
        <td>Address</td>
        <td style="padding:10px 0;"><textarea name="venueAddress"></textarea></td>
      </tr>
      <tr>
        <td>Capacity</td>
        <td><input type="text" name="venueCapacity"></td>
      </tr>
      <tr>
        <td>Room Number</td>
        <td><input type="text" name="roomNumber"></td>
      </tr>
       <tr>
        <td>Floor</td>
        <td><input type="text" name="floor"></td>
      </tr>
      <tr>
        <td>Projector Provided</td>
        <td style="padding:10px 0;">
        <input type="radio" name="projectorProvided" value="Y" checked> Yes
        <input type="radio" name="projectorProvided" value="N" > No
        </td>
      </tr>
      <tr>
        <td>Refreshments available</td>
        <td style="padding:10px 0;">
        <input type="radio" name="refreshmentAvailable" value="Y" checked> Yes
        <input type="radio" name="refreshmentAvailable" value="N"> No
        </td>
      </tr>
      <tr>
        <td>Breaks</td>
        <td style="padding:10px 0;">
        Breakfast <input type="checkbox" name="1" value="breakfast">
        Lunch <input type="checkbox" name="3" value="Lunch">
        Tea <input type="checkbox" name="2" value="tea"> 
        </span>
        </td>
      </tr>
      <tr>
        <td>Additional information</td>
        <td style="padding:10px 0;"><textarea name="additionalInformation"></textarea></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><input class="submit" type="submit" value="Add Venue" /></td>
      </tr>
    </table>
  </form>';

include_once '../footer.php';
?>

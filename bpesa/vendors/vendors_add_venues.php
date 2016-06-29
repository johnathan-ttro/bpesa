<?php
error_reporting(E_ALL ^ E_DEPRECATED);
require_once '../config.php';
require_once '../header.php';
include '../sessionTest.php';

$currentpage = basename($_SERVER['PHP_SELF']); 
$currentpage = substr($currentpage, 0, -4);

echo '
    <br />
    <br />
    <h4><span class="selectorbutton">Add a Venue</span></h4></div>
    <br />
        <form action="' . HOSTNAME . 'functions/vendor_add_venue.php" method="post">
          <table width="600px" cellspacing=0 cellpadding=0>
            <tr>
              <td>Venue Name</td>
              <td>
                <input type="hidden" name="userId" value="' . $_SESSION['userId'] . '" >
                <input type="hidden" name="originUrl" value="' . $currentpage . '" >
                <input type="text" name="vendorName">
              </td>
            </tr>
            <tr>
              <td>Vendor Email</td>
              <td><input type="text" name="vendorEmail"></td>
            </tr>
            <tr>
              <td>Vendor Telephone</td>
              <td><input type="text" name="vendorTel"></td>
            </tr>
            <tr>
              <td>Location</td>
              <td><input type="text" name="vendorLocation"></td>
            </tr>
            <tr>
              <td>Address</td>
              <td style="padding:10px 0;"><textarea name="vendorAddress"></textarea></td>
            </tr>
            <tr>
              <td>Capacity</td>
              <td><input type="text" name="vendorCapacity"></td>
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
              Breakfast   <input type="checkbox" name="break[]" value="breakfast">
              Tea         <input type="checkbox" name="break[]" value="tea">
              Breakfast   <input type="checkbox" name="break[]" value="Lunch">
              Tea         <input type="checkbox" name="break[]" value="Other"> 
              </span>
              </td>
            </tr>
            <tr>
              <td>Additional information</td>
              <td style="padding:10px 0;"><textarea name="additionalInformation"></textarea></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td><input type="submit" name="submit" class="submit" value="Add Venue"></td>
            </tr>
          </table>    
        </form>
      <br/>';      
include '../footer.php';
?>

<?php
error_reporting(E_ALL ^ E_DEPRECATED);
$page_title = 'BpeSA skills Portal - Venues';
require_once '../config.php';
require_once '../header.php';
include '../sessionTest.php';

$currentpage = basename($_SERVER['PHP_SELF']); 
$currentpage = substr($currentpage, 0, -4);

$dbconnect = NEW DB_Class();

$myVenueContentSql = "SELECT pageContent FROM providerpages WHERE pageUrl = '" . $currentpage . "'";
$myVenueContent = $dbconnect->getone($myVenueContentSql);

$myVenueListsSql = "SELECT
                    id,
                    vendorName,
                    venueBooked,
                    active 
                    FROM vendors
                    WHERE userId = " . $_SESSION['userId'] . "";
$myVenueLists = $dbconnect->fetch($myVenueListsSql);
echo $myVenueContent;
echo '
<h1 class="page-title"><span class="current-page">Ven</span>ues</h1>
  <table class="table1">
    <th>Venue Name</th>
    <th>Active</th>
    <th>Booking Status</th>';
    if(!empty($myVenueLists)) {   
      foreach($myVenueLists as $myVenueList) {
        echo '
          <tr>
            <td>' . $myVenueList['vendorName']  . '</td>';
            if($myVenueList['active'] == 'Y') {
               echo '
               <td>
                 <a href="' . HOSTNAME . 'functions/operators_venue_active.php?vendorId=' . $myVenueList['id']  . '&status=Y&originUrl=' . $currentpage .'">
                   <img src="' . HOSTNAME . 'images/tick.jpg" width="15px">
                 </a>
               </td>';
            } else {
               echo '
               <td>
                  <a href="' . HOSTNAME . 'functions/operators_venue_active.php?vendorId=' . $myVenueList['id']  . '&status=N&originUrl=' . $currentpage .'">
                    <img src="' . HOSTNAME . 'images/cross.jpg" width="15px">
                  </a>
               </td>';
            }
            if($myVenueList['venueBooked'] == 'Y') {
              echo '<td><a href="' . HOSTNAME . 'operators/operators_view_venue_bookings.php?vendorId=' . $myVenueList['id'] . '">View Bookings</a></td>';
            } else {
              echo '<td>Not Booked</td>';
            }
          echo '</tr>';
      }
    } else {
        echo '
          <tr>
            <td colspan="3">You have no listed venues</td>
          </tr>';
    }
echo '
  </table>
  <br />
  <br />
  <div id="showFormButton"><h2><span class="selectors">Add a Venue</span></h2></div>
  <br />
  <div id="showEmailForm" style="display:none;" class="col-lg-6 col-lg-offset-1 col-md-6 col-md-12 col-xs-12">
  <form name="addVenueForm" action="' . HOSTNAME . 'functions/operators_venue_save.php" method="post"  onsubmit="return validateAddVenueForm()">
    <table class="table">
      <tr>
        <td><label class="text-info">Venue name</label></td>
        <td>
			      <input name="venueName" class="form-control" type="text">
            <input type="hidden" name="userId" value="' . $_SESSION['userId'] . '">
            <input type="hidden" name="originUrl" value="' . $currentpage . '">
        </td>
      </tr>
      <tr>
        <td><label class="text-info">Email Address</label></td>
        <td><input name="venueEmail" class="form-control" type="text"></td>
      </tr>
      <tr>
        <td><label class="text-info">Telephone</label></td>
        <td><input name="venueTel" class="form-control" type="text"></td>
      </tr>
      <tr>
        <td><label class="text-info">Location</label></td>
        <td><input name="venueLocation" class="form-control" type="text"></td>
      </tr>
      <tr>
        <td><label class="text-info">Address</label></td>
        <td><textarea name="venueAddress"></textarea></td>
      </tr>
      <tr>
        <td><label class="text-info">Capacity</label></td>
        <td><input type="text" name="venueCapacity" class="form-control"></td>
      </tr>
      <tr>
        <td><input class="btn btn-primary" type="submit" value="Add Venue"></td>
        <td>&nbsp;</td>
      </tr>
    </table>
  </form>
  </div>';

include '../footer.php';
?>

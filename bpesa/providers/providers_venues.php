<?php
error_reporting(E_ALL ^ E_DEPRECATED);
$page_title = 'BpeSA skills Portal - Provider Venues';
require_once '../config.php';
require_once '../header.php';
require_once '../sessionTest.php';

$currentpage = basename($_SERVER['PHP_SELF']); 
$currentpage = substr($currentpage, 0, -4);

$dbconnect = NEW DB_Class();

if(isset($_POST)){

  $filterRegionName = $_POST['formFilter'];

  if($filterRegionName != 'N/A'){
    $where = ' AND vendors.province LIKE "%' . $_POST['formFilter'] . '%"';
  }else{
    $where = '';
  }
}

$myVenueContentSql = "SELECT pageContent FROM providerpages WHERE pageUrl = '" . $currentpage . "'";
$myVenueContent = $dbconnect->getone($myVenueContentSql);

$regionNamesSql = "SELECT id, regionNames FROM regions";
$regionNamesOptions = $dbconnect->fetch($regionNamesSql);

$filterregionNamesSql = "SELECT id, regionNames FROM regions";
$filterregionNamesLists = $dbconnect->fetch($filterregionNamesSql);

$myVenueListsSql = "SELECT
                    id,
                    vendorName,
                    venueBooked,
                    vendorLocation,
                    province,
                    active 
                    FROM vendors
                    WHERE userId = " . $_SESSION['userId'] . "" . $where;
$myVenueLists = $dbconnect->fetch($myVenueListsSql);
echo $myVenueContent;

$bookVenuesListsSql = 'SELECT
                        vendors.id,
                        courses.courseName,
                        vendors.vendorName,
                        vendor_link.courseStartDate,
                        vendor_link.courseEndDate,
                        providers.CompanyName
                        FROM vendors
                        INNER JOIN vendor_link ON vendors.id = vendor_link.vendorId
                        INNER JOIN courses ON vendor_link.courseId = courses.id
                        INNER JOIN providers ON courses.providerId = providers.id
                        WHERE vendors.userId = ' . $_SESSION['userId'] . $where;

$bookedVenueLists = $dbconnect->fetch($bookVenuesListsSql);

echo '
  <br/>
  <br/>
  <form action="providers_venues.php" method="post">
  <input type="hidden" name="startDate" value="' . $_REQUEST['startDate'] . '" />
  <input type="hidden" name="endDate" value="' . $_REQUEST['endDate'] . '" />
    <span id="hideSelectOption">
    <div id="selectDiv" style="float:left;">
      <select name="formFilter">
      <option value="N/A" selected="selected"> Select All </option> ';
      foreach($filterregionNamesLists as $filterregionNamesList){
        echo '<option value="' . $filterregionNamesList['regionNames'] . '">' . $filterregionNamesList['regionNames'] . '</option>';
      }
       
echo '
    </select>
  </div>
  <div style="clear:both;"></div>
  </span>
  <br >
  <input type="submit" class="submit" style="background:#ed7b21 url('."'../images/filter_btn.png'".') center right no-repeat !important" value="Filter Records">
  </form>
  <br/>';

echo '
  <br />
  <br />
  <table class="table1" >
    <th>Venue Name</th>
    <th>Active</th>
    <th>Venue Location</th>
    <th>Booking Status</th>';
    if(!empty($myVenueLists)) {   
      foreach($myVenueLists as $myVenueList) {
        echo '
          <tr>
            <td><a href="' . HOSTNAME . 'providers/providers_venue_update.php?vendorId=' . $myVenueList['id']  . '">' . $myVenueList['vendorName']  . '</a></td>';
            if($myVenueList['active'] == 'Y') {
               echo '
               <td style="text-align:center">
                 <a href="' . HOSTNAME . 'functions/venue_active.php?vendorId=' . $myVenueList['id']  . '&status=Y&originUrl=' . $currentpage .'">
                   <img src="' . HOSTNAME . 'images/tick.jpg" width="15px" >
                 </a>
               </td>';
            } else {
               echo '
               <td style="text-align:center">
                  <a href="' . HOSTNAME . 'functions/venue_active.php?vendorId=' . $myVenueList['id']  . '&status=N&originUrl=' . $currentpage .'">
                    <img src="' . HOSTNAME . 'images/cross.jpg" width="15px" >
                  </a>
               </td>';
            }
            if($myVenueList['province'] == 'N/A') {
               echo '<td><a href="' . HOSTNAME . 'providers/providers_venue_update.php?vendorId=' . $myVenueList['id']  . '">Add province </a> - ' . $myVenueList['vendorLocation']  . '</a></td>';
            } else {
              echo '<td>' . $myVenueList['province']  . ' - ' . $myVenueList['vendorLocation']  . '</a></td>';
            }
            if($myVenueList['venueBooked'] == 'Y') {
              echo '<td><a href="' . HOSTNAME . 'providers/providers_view_venue_bookings.php?vendorId=' . $myVenueList['id'] . '">View Bookings</a></td>';
            } else {
              echo '<td>Unavailable</td>';
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
  <div id="showEmailForm" style="display:none;">
  <form action="' . HOSTNAME . 'functions/providers_venue_save.php" method="post" id="providerAddVenue" name="providerAddVenue"  onsubmit="return validateForm8()" >
    <table width="600px" id="form2">
      <tr>
        <td>Venue name</td>
        <td><input name="venueName" type="text">
            <input type="hidden" name="userId" value="' . $_SESSION['userId'] . '">
            <input type="hidden" name="originUrl" value="' . $currentpage . '">
        </td>
      </tr>
      <tr>
        <td>Email Address</td>
        <td>
          <input name="venueEmail" type="text">
          <div class="hover" style="left:228px; top:-35px;">
		  <img src="' . HOSTNAME . 'images/icon.png">
          <div class="tooltip">The email that is used to communicate with the venue.</div>
          </div>
        </td>
      </tr>
      <tr>
        <td>Telephone</td>
        <td>
          <input name="venueTel" type="text">
          <div class="hover" style="left:228px; top:-35px;"><img src="' . HOSTNAME . 'images/icon.png">
            <div class="tooltip">The contact number for the the venue.</div>
          </div>
        </td>
      </tr>
      <tr>
        <td>Location</td>
        <td>
          <input name="venueLocation" type="text">
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
    <td>Select Province</td> 
    <td>';
echo '<div style="float:left;" id="selectDiv">
        <select name="province">
          <option value="N/A" selected>Select One</option>';
        foreach($regionNamesOptions as $regionNamesOption) {
            echo '<option value="' . $regionNamesOption['regionNames'] . '">' . $regionNamesOption['regionNames'] . '</option>';  
        }
echo '</select>
        </div>'; 
echo '</td>    
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
        Tea <input type="checkbox" name="2" value="tea">
        Breakfast <input type="checkbox" name="3" value="Lunch">
        Tea <input type="checkbox" name="4" value="Other"> 
        </span>
        </td>
      </tr>
      <tr>
        <td>Additional information</td>
        <td style="padding:10px 0;"><textarea name="additionalInformation"></textarea></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><input class="submit" type="btn btn-primary" value="Add Venue"></td>
      </tr>
    </table>
  </form>
  </div>
  <br/>';
include '../footer.php';
?>

<?php
error_reporting(E_ALL ^ E_DEPRECATED);
$page_title = 'BpeSA skills Portal - Venues';
require_once '../config.php';
require_once '../header.php';
require_once '../sessionTest.php';

$currentpage = basename($_SERVER['PHP_SELF']); 
$currentpage = substr($currentpage, 0, -4);

$regionNamesSql = "SELECT id, regionNames FROM regions";
$regionNamesOptions = $dbconnect->fetch($regionNamesSql);

if(isset($_POST)){

  $filterRegionName = $_POST['formFilter'];

  if($filterRegionName != 'N/A'){
    $where = ' AND vendors.province LIKE "%' . $_POST['formFilter'] . '%"';
  }else{
    $where = '';
  }
}

$vendorVenuesListSql = 'SELECT 
                        id,
                        vendorName, 
                        vendorEmail, 
                        vendorTel, 
                        vendorLocation,
                        province, 
                        vendorAddress,
                        vendorCapacity,
                        active
                        FROM vendors
                        WHERE userId = ' . $_SESSION['userId'];

$vendorVenuesLists = $dbconnect->fetch($vendorVenuesListSql);

$bookVenuesListsSql = 'SELECT
                       vendors.vendorName,
                       courses.id,
                       courses.courseName,
                       vendor_link.courseStartDate,
                       vendor_link.courseEndDate,
                       providers.companyName,
                       providers.badge
                       FROM vendors
                       INNER JOIN vendor_link ON vendors.id = vendor_link.vendorId
                       INNER JOIN courses ON vendor_link.courseId = courses.id
                       INNER JOIN providers ON courses.providerId = providers.id
                       WHERE vendors.userId = ' . $_SESSION['userId'] . '
                       AND courses.archived != "Y"' . $where;

$bookedVenueLists = $dbconnect->fetch($bookVenuesListsSql);

$filterregionNamesSql = "SELECT id, regionNames FROM regions";
$filterregionNamesLists = $dbconnect->fetch($filterregionNamesSql);

echo '
  <h1 class="page-title"><span class="current-page">Man</span>age Venues</h1>
  <form action="vendors_venues.php" method="post">
  <table class="table">
  <tr>
  <td> 
  <input type="hidden" name="startDate" value="' . $_REQUEST['startDate'] . '">
  <input type="hidden" name="endDate" value="' . $_REQUEST['endDate'] . '"> 
  <span id="hideSelectOption">
    <div id="selectDiv" style="float:left;">
      <select name="formFilter">
      <option value="N/A" selected="selected"> Select All </option> ';
      foreach($filterregionNamesLists as $filterregionNamesList){
        echo '<option value="' . $filterregionNamesList['regionNames'] . '">' . $filterregionNamesList['regionNames'] . '</option>';
      }
       
	echo '
    </select>
	</span> 
	</div>
	<span style="padding-left:15px;"><input type="submit"  class="btn btn-primary" value="Filter Records"></span></td>
  </tr>
  </table>
  </form>';
if($vendorVenuesLists) {
  echo '
  <h4>Available Venues</h4>
    <table class="table1">
      <th>Venue Name</th>
      <th>Venue Email</th>
      <th>Venue Contact Number</th>
      <th>Venue Location</th>
      <th>Status</th>';
       
  foreach($vendorVenuesLists as $vendorVenuesList) {
    echo '
    <tr>
      <td><a href="' . HOSTNAME . 'vendors/vendors_venue_update.php?venueId=' . $vendorVenuesList['id'] . '&originUrl=' . $currentpage .'">' . $vendorVenuesList['vendorName'] . '</a></td>
      <td>' . $vendorVenuesList['vendorEmail'] . '</td>
      <td>' . $vendorVenuesList['vendorTel'] . '</td>';

      if($vendorVenuesList['province'] == 'N/A') {
        echo '<td><a href="' . HOSTNAME . 'vendors/vendors_venue_update.php?venueId=' . $vendorVenuesList['id'] . '&originUrl=' . $currentpage .'">Add province </a> - '. $vendorVenuesList['vendorLocation'] . '</td>';
      }else{
        echo '<td>' . $vendorVenuesList['province'] . ' - '. $vendorVenuesList['vendorLocation'] . '</td>';
      }

      if($vendorVenuesList['active'] == 'Y') {
        echo '
          <td>
            <a href="' . HOSTNAME . 'functions/venue_status_update.php?userId=' . $_SESSION['userId'] .'&venueId=' . $vendorVenuesList['id'] . '&active=Y&originUrl=' . $currentpage . '">
              <img src="' . HOSTNAME . 'images/tick.jpg" width="15px" >
            </a>
          </td>';
      } else {
       echo '
         <td>
           <a href="' . HOSTNAME . 'functions/venue_status_update.php?userId=' . $_SESSION['userId'] .'&venueId=' . $vendorVenuesList['id'] . '&active=N&originUrl=' . $currentpage . '">
             <img src="' . HOSTNAME . 'images/cross.jpg" width="15px" >
           </a>
         </td>';
      }
    echo '
    </tr>';
  }
  echo '
    </table>
    <h4>Current Bookings</h4>
    <table class="table1">
      <th>Venue</th>
      <th>Start Date</th>
      <th>End Date</th>
      <th>Company</th>';
      if(!empty($bookedVenueLists)){
      foreach($bookedVenueLists as $bookedVenueList) {

        if($bookedVenueList['badge'] == "Y") {
          $courseBadge = '<span class="badge">' . $bookedVenueList['companyName'] . '</span> ';
          $height = ' style="height:60px;"';
        }else{
            $courseBadge = '' . $bookedVenueList['companyName'] . '';
             $height = false;
        } 

        echo '
        <tr ' . $height . '>
          <td>' . $bookedVenueList['vendorName'] . '</td>
          <td>' . $bookedVenueList['courseStartDate'] . '</td>
          <td>' . $bookedVenueList['courseEndDate'] . '</td>
          <td>' . $courseBadge . '</td>
        </tr>'; 
      }
    }else{
      echo '
      <tr>
        <td colspan="4">There are no current bookings</td>
      </tr>';
    }
      echo '
      </table>';
} 
echo '
  <div id="showFormButton">
	<h2><span class="selectors">Add a Venue</span></h2>
  </div>
  
  <div class="col-lg-6 col-lg-offset-1 col-md-6 col-sm-12 col-xs-12">
  <div id="showEmailForm" style="display:none;">
   <form action="' . HOSTNAME . 'functions/vendor_add_venue.php" method="post" id="providerAddVenue" name="providerAddVenue"  onsubmit="return validateForm8()" >
          <table class="table">
            <tr>
              <td><label class="text-info">Venue Name</label></td>
              <td>
                <input type="hidden" name="userId" value="' . $_SESSION['userId'] . '" >
                <input type="hidden" name="originUrl" value="' . $currentpage . '" >
                <input type="text" class="form-control" name="vendorName">
              </td>
            </tr>
            <tr>
              <td><label class="text-info">Vendor Email</label></td>
              <td><input type="text" class="form-control" name="vendorEmail"></td>
            </tr>
            <tr>
              <td><label class="text-info">Vendor Telephone</label></td>
              <td><input type="text" class="form-control" name="vendorTel"></td>
            </tr>
            <tr>
              <td><label class="text-info">Select Province</label></td> 
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
              <td><label class="text-info">Location</label></td>
              <td><input type="text" class="form-control" name="vendorLocation"></td>
            </tr>
            <tr>
              <td><label class="text-info">Address</label></td>
              <td style="padding:10px 0;"><textarea name="vendorAddress"></textarea></td>
            </tr>
            <tr>
              <td><label class="text-info">Capacity</label></td>
              <td><input type="text" class="form-control" name="vendorCapacity"></td>
            </tr>
            <tr>
              <td><label class="text-info">Room</label></td>
              <td><input type="text" class="form-control" name="roomNumber"></td>
            </tr>
             <tr>
              <td><label class="text-info">Floor</label></td>
              <td><input type="text" class="form-control" name="floor"></td>
            </tr>
            <tr>
              <td><label class="text-info">Projector Provided</label></td>
              <td style="padding:10px 0;">
				  <input type="radio" name="projectorProvided" value="Y" checked="checked"> Yes
				  <input type="radio" name="projectorProvided" value="N" > No
              </td>
            </tr>
            <tr>
              <td><label class="text-info">Refreshments available</label></td>
              <td style="padding:10px 0;">
              <input type="radio" name="refreshmentAvailable" value="Y" checked="checked"> Yes
              <input type="radio" name="refreshmentAvailable" value="N"> No
              </td>
            </tr>
            <tr>
              <td><label class="text-info">Breaks</label></td>
              <td style="padding:10px 0;">
              Breakfast <input type="checkbox" name="break[]" value="breakfast">
              Tea <input type="checkbox" name="break[]" value="tea">
              Lunch <input type="checkbox" name="break[]" value="lunch">
              </span>
              </td>
            </tr>
            <tr>
              <td><label class="text-info">Additional information</label></td>
              <td style="padding:10px 0;"><textarea name="additionalInformation"></textarea></td>
            </tr>
            <tr>
              <td><input type="submit" class="btn btn-primary" name="submit"  value="Add Venue"></td>
              <td>&nbsp;</td>
            </tr>
          </table>    
        </form>
      </div>
	  </div>
	  <br/>';
include '../footer.php';
?>

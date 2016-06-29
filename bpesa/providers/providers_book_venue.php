<?php
error_reporting(E_ALL ^ E_DEPRECATED);
$page_title = 'BpeSA skills Portal - Book a Venue';
require_once '../config.php';
require_once '../header.php';

$dbconnect = NEW DB_Class();

$filterregionNamesSql = "SELECT id, regionNames FROM regions";
$filterregionNamesLists = $dbconnect->fetch($filterregionNamesSql);

echo '
  <h1 class="page-title"><span class="current-page">Cou</span>rse Attendees</h1>

  <form action="providers_book_venue.php" method="post">
  <input type="hidden" name="startDate" value="' . $_REQUEST['startDate'] . '" />
  <input type="hidden" name="endDate" value="' . $_REQUEST['endDate'] . '" />
  <input type="hidden" name="courseId" value="' . $_REQUEST['courseId'] . '" />
    <span id="hideSelectOption">
    <div id="selectDiv" style="float:left;">
      <select name="formFilter">
      <option value="N/A" selected>Select All</option>';
      foreach($filterregionNamesLists as $filterregionNamesList){
        echo '<option value="' . $filterregionNamesList['regionNames'] . '">' . $filterregionNamesList['regionNames'] . '</option>';
      }  
echo '</select>
  </div>
  <div style="clear:both;"></div>
  </span>
  <br >
  <input type="submit" class="btn btn-primary" value="Filter Records">
  </form>
  <br/>';

if(isset($_POST)){

  $filterRegionName = $_POST['formFilter'];

  if($filterRegionName!= 'N/A'){
    $where = ' AND province LIKE "%' . $_POST['formFilter'] . '%"';
  }else{
    $where = '';
  }
}

$bookedVenuesSql = "SELECT vendors.id
                    FROM vendors
                    INNER JOIN vendor_link
                    ON vendors.id = vendor_link.vendorId
                    WHERE vendor_link.courseStartDate BETWEEN '" . $_REQUEST['startDate'] . "' AND '" . $_REQUEST['endDate'] . "'";

$bookedVenues = $dbconnect->fetch($bookedVenuesSql);
$bookedVenueToExclude = '';
foreach($bookedVenues as $bookedVenue) {
    $bookedVenueToExclude.= $bookedVenue['id'] . ',';
}
$bookedVenueToExclude = rtrim($bookedVenueToExclude, ",");
if(!empty($bookedVenueToExclude)) {
  $availableVenuesSql = 'SELECT id, vendorName, vendorCapacity, vendorLocation, province, roomNumber, projectorProvided, refreshmentAvailable, additionalInformation FROM vendors WHERE id NOT IN(' . $bookedVenueToExclude . ') AND active = "Y"' . $where;
} else {
  $availableVenuesSql = 'SELECT id, vendorName, vendorCapacity, vendorLocation, province, roomNumber, projectorProvided, refreshmentAvailable, additionalInformation FROM vendors WHERE active = "Y"' . $where ;   
}
$availableVenues = $dbconnect->fetch($availableVenuesSql);

echo '
<h4>Book a Venue</h4>
<table width="95%" cellspacing="3" cellpadding="3" class="table1">
  <th width="10%">Vendor Name</th>
  <th width="5.5%">Venue Capacity</th>
  <th width="15%">Vendor Location</th>
  <th width="5%">Room Number</th>
  <th width="5%">Projector Provided</th>
  <th width="10%">Additional Information</th>
  <th width="6%">Book</th>'; 
  if(!empty($availableVenues)){
  foreach($availableVenues as $availableVenue) {

    $currentBreakSql = 'SELECT breakName FROM breaks WHERE vendorId = ' . $availableVenue['id'];
    $currentBreakLists = $dbconnect->getone($currentBreakSql);

    echo '
    <tr>
      <td>' . $availableVenue['vendorName'] . '</td>
      <td>' . $availableVenue['vendorCapacity'] . '</td>
      <td>' . $availableVenue['province']  . ' - ' . $availableVenue['vendorLocation']  . '</td>
      <td>' . $availableVenue['roomNumber'] . '</td>
      <td>';
      if($availableVenue['projectorProvided'] == 'Y'){
        echo 'Yes';
      }else{
        echo 'No';
      }
    echo '</td>
      <td>' . $availableVenue['additionalInformation'] . '</td>';
    echo '<td>
          <a href="' . HOSTNAME . 'functions/providers_book_save.php?vendorId=' . $availableVenue['id'] . '&courseId=' . $_REQUEST['courseId'] . '&startDate=' . $_REQUEST['startDate'] .'&endDate=' . $_REQUEST['endDate'] .'&updateVendorId=' . $_REQUEST['updatevendorId'] . '">
            Book Now
          </a>
       </td>
      </tr>';
  } 
}else{
  echo '<tr>
          <td colspan="4">There are no venues in that province</td>
        </tr>';
}
echo '</table>
<br/>
<form action="'. HOSTNAME . 'providers/providers_courses.php" method="post">
<input type="submit" class="btn btn-primary" name="submit" value="Back" />
</form>
<br/>';
include '../footer.php';
?>

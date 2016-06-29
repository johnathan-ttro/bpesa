<?php
error_reporting(E_ALL ^ E_DEPRECATED);
$page_title = 'BpeSA skills Portal - Book a Venue';
require_once '../config.php';
require_once '../header.php';

$dbconnect = NEW DB_Class();

$bookedVenuesSql = "SELECT vendors.id 
                    FROM vendors
                    INNER JOIN vendor_link
                    ON vendors.id = vendor_link.vendorId
                    WHERE vendor_link.courseStartDate BETWEEN '" . $_GET['startDate'] . "' AND '" . $_GET['endDate'] . "'";

$bookedVenues = $dbconnect->fetch($bookedVenuesSql);
$bookedVenueToExclude = '';
foreach($bookedVenues as $bookedVenue) {
    $bookedVenueToExclude.= $bookedVenue['id'] . ',';
}
$bookedVenueToExclude = rtrim($bookedVenueToExclude, ",");
if(!empty($bookedVenueToExclude)) {
  $availableVenuesSql = 'SELECT id, vendorName FROM vendors WHERE id NOT IN(' . $bookedVenueToExclude . ') AND active = "Y"';
} else {
  $availableVenuesSql = 'SELECT id, vendorName FROM vendors WHERE active = "Y"';   
}
$availableVenues = $dbconnect->fetch($availableVenuesSql);

echo '
<h1 class="page-title"><span class="current-page">Boo</span>k a Venue</h1>
<table class="table1">
  <th>Vendor Name</th>
  <th>Book</th>'; 
  foreach($availableVenues as $availableVenue) {    
    echo '
    <tr>
      <td>' . $availableVenue['vendorName'] . '</td>
        <td>
          <a href="' . HOSTNAME . 'functions/operators_book_save.php?vendorId=' . $availableVenue['id'] . '&courseId=' . $_GET['courseId'] . '&startDate=' . $_GET['startDate'] .'&endDate=' . $_GET['endDate'] .'">
            Book Now
          </a>
       </td>
      </tr>';
  }
echo '</table>';
include '../footer.php';
?>

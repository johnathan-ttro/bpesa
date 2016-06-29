<?php
//turn off deprecicated warnings
error_reporting(E_ALL ^ E_DEPRECATED);
require_once '../config.php';
require_once '../header.php';
include '../sessionTest.php';


$listBookedVenuesSql = 'SELECT
                        vendors.vendorName,
                        vendor_link.courseStartDate,
                        vendor_link.courseEndDate,
                        providers.CompanyName
                        FROM vendors
                        INNER JOIN vendor_link ON vendors.id = vendor_link.vendorId
                        INNER JOIN courses ON vendor_link.courseId = courses.id
                        INNER JOIN providers ON courses.providerId = providers.id
                        WHERE vendors.id = ' . $_GET['vendorId'];

$listBookedVenues = $dbconnect->fetch($listBookedVenuesSql);

echo '
  <table class="table1">
    <th>Venue Name</th>
    <th>Booked From</th>
    <th>Booked Until</th>
    <th>Booked By</th>';
foreach($listBookedVenues as $listBookedVenue) {
  echo '
    <tr>
      <td>' . $listBookedVenue['vendorName'] . '</td>
      <td>' . $listBookedVenue['courseStartDate'] . '</td>
      <td>' . $listBookedVenue['courseEndDate'] . '</td>
      <td>' . $listBookedVenue['CompanyName'] . '</td>
    </tr>';
}
echo '</table>';
include '../footer.php';
?>

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
                        providers.CompanyName,
                        providers.badge
                        FROM vendors
                        INNER JOIN vendor_link ON vendors.id = vendor_link.vendorId
                        INNER JOIN courses ON vendor_link.courseId = courses.id
                        INNER JOIN providers ON courses.providerId = providers.id
                        WHERE vendors.id = ' . $_GET['vendorId'];

$listBookedVenues = $dbconnect->fetch($listBookedVenuesSql);

if(!empty($listBookedVenues)){
echo '
  <table class="table1">
    <th>Venue Name</th>
    <th>Booked From</th>
    <th>Booked Until</th>
    <th>Booked By</th>';
foreach($listBookedVenues as $listBookedVenue) {
      if($listBookedVenue['badge'] == "Y") {
          $companyName = '<span class="badge">' . $listBookedVenue['CompanyName'] . '</span> ';
          $style = ' style="height:60px;"';
      }else{
          $companyName = '' . $listBookedVenue['CompanyName'] . '';
          $style = false;
      } 
  echo '
    <tr ' . $style . '>
      <td>' . $listBookedVenue['vendorName'] . '</td>
      <td>' . $listBookedVenue['courseStartDate'] . '</td>
      <td>' . $listBookedVenue['courseEndDate'] . '</td>
      <td>' . $companyName . '</td>
    </tr>';
}
echo '</table><br/>';

}else{
  echo "the venue is not booked <br/>";
}

include '../footer.php';
?>

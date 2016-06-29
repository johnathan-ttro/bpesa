<?php
error_reporting(E_ALL ^ E_DEPRECATED);
$page_title = 'BpeSA skills Portal - Available Venues';
require_once '../config.php';
require_once '../header.php';
include '../sessionTest.php';

$currentpage = basename($_SERVER['PHP_SELF']); 
$currentpage = substr($currentpage, 0, -4);

$vendorVenuesListSql = 'SELECT 
                        id,
                        vendorName, 
                        vendorEmail, 
                        vendorTel, 
                        vendorLocation, 
                        vendorAddress,
                        vendorCapacity,
                        active
                        FROM vendors';

$vendorVenuesLists = $dbconnect->fetch($vendorVenuesListSql);

$bookVenuesListsSql = 'SELECT
                       vendors.vendorName,
                       courses.courseName,
                       vendor_link.courseStartDate,
                       vendor_link.courseEndDate,
                       providers.companyName,
                       providers.badge
                       FROM vendors
                       INNER JOIN vendor_link ON vendors.id = vendor_link.vendorId
                       INNER JOIN courses ON vendor_link.courseId = courses.id
                       INNER JOIN providers ON courses.providerId = providers.id
                       WHERE courses.archived != "Y"';

$bookedVenueLists = $dbconnect->fetch($bookVenuesListsSql);

if($vendorVenuesLists) {
  echo '
    <h1 class="page-title"><span class="current-page">Avai</span>lable Venues</h1>
    <br/>
    <table class="table1">
      <th>Venue Name</th>
      <th>Venue Email</th>
      <th>Venue Contact Number</th>
      <th>Venue Location</th>
      <th>Active</th>';
       
  foreach($vendorVenuesLists as $vendorVenuesList) {
    echo '
    <tr>
      <td><a href="' . HOSTNAME . 'vendors/vendors_venue_update.php?venueId=' . $vendorVenuesList['id'] . '&originUrl=' . $currentpage .'">' . $vendorVenuesList['vendorName'] . '</a></td>
      <td>' . $vendorVenuesList['vendorEmail'] . '</td>
      <td>' . $vendorVenuesList['vendorTel'] . '</td>
      <td>' . $vendorVenuesList['vendorLocation'] . '</td>';
      if($vendorVenuesList['active'] == 'Y') {
        echo '
          <td style="text-align:center">
            <a href="' . HOSTNAME . 'functions/venue_status_update.php?userId=' . $_SESSION['userId'] .'&venueId=' . $vendorVenuesList['id'] . '&active=Y&originUrl=' . $currentpage . '">
              <img src="' . HOSTNAME . 'images/tick.jpg" width=15px/>
            </a>
          </td>';
      } else {
       echo '
         <td style="text-align:center">
           <a href="' . HOSTNAME . 'functions/venue_status_update.php?userId=' . $_SESSION['userId'] .'&venueId=' . $vendorVenuesList['id'] . '&active=N&originUrl=' . $currentpage . '">
             <img src="' . HOSTNAME . 'images/cross.jpg" width="15px" />
           </a>
         </td>';
      }
    echo '
    </tr>';
  }
 echo '
    </table>
    <br />
    <br />
    <h4>Current Bookings</h4>
    <table class="table1">
      <th>Venue</th>
      <th>Start Date</th>
      <th>End Date</th>
      <th>Company</th>';
      foreach($bookedVenueLists as $bookedVenueList) {
        if($bookedVenueList['badge'] == "Y") {
          $companyName = '<span class="badge">' . $bookedVenueList['companyName'] . '</span> ';
          $style = ' style="height:60px;"';
        }else{
          $companyName = '' . $bookedVenueList['companyName'] . '';
          $style = false;
        } 
        echo '
        <tr '. $style .'>
          <td>' . $bookedVenueList['vendorName'] . '</td>
          <td>' . $bookedVenueList['courseStartDate'] . '</td>
          <td>' . $bookedVenueList['courseEndDate'] . '</td>
          <td>' . $companyName . '</td>
        </tr>'; 
      }
      echo '
      </table>';
}
echo '
  <br />
  <a href="' . HOSTNAME . 'admin/admin_reports.php"><strong>Back</strong></a>
  <br />
  <br />';
include '../footer.php';
?>

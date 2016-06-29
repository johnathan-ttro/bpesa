<?php
//turn off deprecicated warnings
error_reporting(E_ALL ^ E_DEPRECATED);
$page_title = 'BpeSA skills Portal - Facilities Provider';
require_once '../config.php';
require_once '../header.php';

$currentpage = basename($_SERVER['PHP_SELF']); 
$currentpage = substr($currentpage, 0, -4);

if(isset($_POST['submit'])) {
  $where = ' WHERE ';
  if(!empty($_POST['activeFilter']) && $_POST['activeFilter'] == 'Y'){
      $where .= ' active = "Y"';
  } 
  if(!empty($_POST['activeFilter']) && $_POST['activeFilter'] == 'N'){
      $where .= ' active = "N"';
  }
  if(!empty($_POST['activeFilter']) && $_POST['activeFilter'] == 'allActive'){
      $where .= ' active = "N" OR active = "Y"';
  }
}
//calendar login
$dbconnect = NEW DB_Class();
if(!empty($where)){
  $thirdPartyListSql = "SELECT id, userId, vendorName, vendorEmail, vendorTel, active FROM vendors " . $where . "";
} else {
  $thirdPartyListSql = "SELECT id, userId, vendorName, vendorEmail, vendorTel, active FROM vendors";
}
$thirdPartyLists = $dbconnect->fetch($thirdPartyListSql);

$thirdPartyPageContentSql = "SELECT pageContent FROM adminpages WHERE pageUrl = '" . $currentpage . "'";
$thirdPartyPageContent = $dbconnect->getone($thirdPartyPageContentSql);


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

?>

<?php
  echo '<h1 class="page-title"><span class="current-page">Fac</span>ilities Provider</h1>' . $thirdPartyPageContent;
?>
<!--Apply the Filter -->
Filter By:
<br />
<form action="admin_third_party.php" method="post" id="thirdPartyForm">
<div id = "selectDiv">
  <select name="activeFilter" form="thirdPartyForm">
    <option value="allActive">All</option>
    <option value="Y">Active</option>
    <option value="N">Not Active</option>
  </select>
</div>
  <br />
  <div id="selectDiv">
  <select name="approvedFilter" form="dashBoardForm">
    <option value="allApproved">All</option>
    <option value="Y">Approved</option>
    <option value="N">Not Approved</option>
  </select>
</div>
  <br />
  <input class="btn btn-primary" type="submit" value="Filter Results" name="submit">
</form>
<!--End the Filter -->
<br />
<table class="table1">
  <th>Vendor Name</th>
  <th>Email</th>
  <th>Tel</th>
  <th style = "border:none;">Active</th>  
  <!--PHP Loop with the providers list-->
  <?php
  foreach($thirdPartyLists as $thirdPartyList) {
    echo '
    <tr>
      <td>' . $thirdPartyList['vendorName'] . '</td>
      <td><a href="' . HOSTNAME . 'admin/admin_send_email.php?recipientId=' . $thirdPartyList['userId'] . '">' . $thirdPartyList['vendorEmail'] . '</td>
      <td>' . $thirdPartyList['vendorTel'] . '</td>';
      if($thirdPartyList['active'] == 'Y') {
        echo '
        <td>
          <a href="' . HOSTNAME . 'functions/third_party_approve.php?thirdPartyId=' . $thirdPartyList['userId']. '&originUrl=' . $currentpage . '&status=Y">
          <img src="' . HOSTNAME . 'images/tick.jpg" width="15px">
          </a>
        </td>';
      } else {
        echo '
        <td>
          <a href="' . HOSTNAME . 'functions/third_party_approve.php?thirdPartyId=' . $thirdPartyList['id']. '&originUrl=' . $currentpage . '&status=N">
          <img src="' . HOSTNAME . 'images/cross.jpg" width="15px">
          </a>
        </td>';
      }
     echo '</tr>';
  }
echo '
    </table>
    <br />
    <br />
    <h4>Current Bookings</h4>
    <table class="table1">
      <th scope="col">Venue</th>
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
  ?>
</table>
<br>
<?php $here = HOSTNAME ; include ('../footer.php'); ?>
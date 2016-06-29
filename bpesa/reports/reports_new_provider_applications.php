<?php
//turn off deprecicated warnings
error_reporting(E_ALL ^ E_DEPRECATED);
$page_title = 'BpeSA skills Portal - Providers Approvals';
require_once '../config.php';
require_once '../header.php';
 
$currentpage = 'admin_reports';

$newProviderApplicationsSql = 'SELECT
                               id,
                               userID,
                               companyName, 
                               contactPerson, 
                               email,
                               contactNumber
                               FROM providers
                               WHERE approved = "N"';

$newProviderApplications = $dbconnect->fetch($newProviderApplicationsSql);

  echo '
  <h1 class="page-title"><span class="current-page">Provi</span>ders Approvals</h1>
  <br />
  <table class="table1">
    <th>Company Name</th>
    <th>Contact Person</th>
    <th>Email</th>
    <th>Contact Number</th>
    <th>Access List</th>';
if($newProviderApplications) {
    foreach($newProviderApplications as $newProviderApplication){
      echo '
      <tr>
        <td>' . $newProviderApplication['companyName'] . '</td>
        <td>' . $newProviderApplication['contactPerson'] . '</td>
        <td>' . $newProviderApplication['email'] . '</td>
        <td>' . $newProviderApplication['contactNumber'] . '</td>
        <td><a href="' . HOSTNAME . 'functions/provider_approve.php?originUrl=' . $currentpage . '&userId=' . $newProviderApplication['userID'] . '&status=N&providerId=' . $newProviderApplication['id'] . '&procedure=approved">Approve this user<a></td>
      </tr>';
    }
  } else {
  echo '<tr>
          <td colspan="5">There are no applicants awaiting approval.</td>
        </tr>';
}
  echo '</table>
        <br/>
        <br/>';


echo '
  <a href="' . HOSTNAME . 'admin/admin_reports.php"><strong>Back</strong></a>
  <br />
  <br />';
include '../footer.php';
?>

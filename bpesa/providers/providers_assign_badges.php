<?php
//turn off deprecicated warnings
error_reporting(E_ALL ^ E_DEPRECATED);
require_once '../config.php';
require_once '../header.php';
 
$currentpage = basename($_SERVER['PHP_SELF']); 
$currentpage = substr($currentpage, 0, -4);

$newProviderApplicationsSql = 'SELECT
                               id,
                               userID,
                               companyName, 
                               contactPerson, 
                               email,
                               badge,
                               contactNumber
                               FROM providers
                               WHERE active = "Y"';

$newProviderApplications = $dbconnect->fetch($newProviderApplicationsSql);
if($newProviderApplications) {
  echo '
  <h2>Providers</h2>
  <p style="margin:0">Click the radio button in the "Assign Badge" column, to mark the provider as a trusted one.</p>
  <br/>
  <table class="table1">
    <th>Company Name</th>
    <th>Contact Person</th>
    <th>Email</th>
    <th>Contact Number</th>
    <th>Assign Badge</th>';
    foreach($newProviderApplications as $newProviderApplication){

      if($newProviderApplication['badge'] == "Y") {
          $active = '<img src="' . HOSTNAME . '/images/active.jpg" width="15px" />';
          $companyName = '<span class="badge">' . $newProviderApplication['companyName'] . '</span> ';
          $style = ' style="height:60px;"';
      } else {
          $active = '<img src="' . HOSTNAME . '/images/non_active.jpg" width="15px" />';
          $companyName = $newProviderApplication['companyName'];
          $style = false;
      }

      echo '
      <tr '. $style .'>
        <td>' . $companyName . '</td>
        <td>' . $newProviderApplication['contactPerson'] . '</td>
        <td>' . $newProviderApplication['email'] . '</td>
        <td>' . $newProviderApplication['contactNumber'] . '</td>
        <td align="center">
        <form action="' . HOSTNAME . 'functions/admin_assign_badges.php" method="post">
            <input type="radio" name="providerId" value="' . $newProviderApplication['userID'] . '" onclick="this.form.submit();" >
            <input type="hidden" name="badge" value="' . $newProviderApplication['badge'] . '" >
            <input type="hidden" name="originUrl" value="' . $currentpage . '">
        </form>
        </td>
      </tr>';
    }
echo '</table>
        <br/>';
} else {
  echo 'There are no applicants awaiting approval.';
}
include '../footer.php';
?>

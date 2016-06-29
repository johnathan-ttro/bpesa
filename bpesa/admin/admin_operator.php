<?php
//turn off deprecicated warnings
error_reporting(E_ALL ^ E_DEPRECATED);
$page_title = 'BpeSA skills Portal - Operator';
require_once '../config.php';
require_once '../header.php';

$currentpage = basename($_SERVER['PHP_SELF']); 
$currentpage = substr($currentpage, 0, -4);

$dbconnect = NEW DB_Class();
$providerListSql = "SELECT userID,companyName, contactPerson, email, active, approved FROM providers";
$providerLists = $dbconnect->fetch($providerListSql);

$providerPageContentSql = "SELECT pageContent FROM adminpages WHERE pageUrl = '" . $currentpage . "'";
$providerPageContent = $dbconnect->getone($providerPageContentSql);
?>
<h1 class="page-title"><span class="current-page">Ope</span>rators</h1>
<?php echo $providerPageContent;?>
<table class="table1">
  <th>Company Name</th>
  <th>Contact Person</th>
  <th>Email</th>
  <th>Active</th>
  <th>Fees Paid</th>
  <!--PHP Loop with the providers list-->
  <?php
  foreach($providerLists as $providerList) {
      echo '<tr >
              <td>' . $providerList['companyName'] . '</td>
              <td>' . $providerList['contactPerson'] . '</td>
              <td><a href="' . HOSTNAME . 'admin/admin_send_email.php?recipientId=' . $providerList['userID'] . '">' . $providerList['email'] . '</a></td>
              <td>' . $providerList['active'] . '</td>
              <td>' . $providerList['approved'] . '</td>
            <tr>';
  }
  ?>
</table>

<?php $here = HOSTNAME ; include ('../footer.php'); ?>
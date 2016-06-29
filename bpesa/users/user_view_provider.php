<?php
error_reporting(E_ALL ^ E_DEPRECATED);
require_once '../config.php';
require_once '../header.php';
include '../sessionTest.php';

$currentpage = basename($_SERVER['PHP_SELF']); 
$currentpage = substr($currentpage, 0, -4);

$dbconnect = NEW DB_Class();

if(!empty($_GET['providerId'])) {
  $viewProviderProfileSql = 'SELECT companyName, contactPerson, email, contactNumber, companyLogo, website, userCompanyProfile
                             FROM providers
                             INNER JOIN users ON providers.userID = users.id
                             WHERE providers.id = ' .  $_GET['providerId'];
  $viewProviderProfiles = $dbconnect->fetch($viewProviderProfileSql);
}

$accredDocsSql = 'SELECT documentName, documentUrl, expiaryDate
                  FROM accreditationdocuments
                  WHERE providerId = ' . $_GET['providerId'];
$accredDocs = $dbconnect->fetch($accredDocsSql);

echo '
  <table width="900px" border="0">';
foreach($viewProviderProfiles as $viewProviderProfile) {
  echo '
    <tr>
      <td><div style="height:120px;"><img src="' . $viewProviderProfile['companyLogo'] . '"></td>
    </tr>    
    <tr>
      <td><h2>' . $viewProviderProfile['companyName'] . '</h2></td>
    </tr>
    <tr>
      <td>' . $viewProviderProfile['userCompanyProfile'] . '</td>
    </tr>
    <tr>
      <td>' . $viewProviderProfile['email'] . '</td>
    </tr>
    <tr>
      <td>' . $viewProviderProfile['contactNumber'] . '</td>
    </tr>
    <tr>
      <td>' . $viewProviderProfile['website'] . '</td>
    </tr>';
}
echo '</table>
    <br />';
if($accredDocs) {
  echo '
  <h2>Accreditiation Documents</h2><br />
    <table width="900px" border="0">';
  foreach($accredDocs as $accredDoc) {
    echo '
    <tr>
      <td><a href="http://' . $accredDoc['documentUrl'] . '">' . $accredDoc['documentName'] . '</a></td>
      <td>' . $accredDoc['expiaryDate'] . '</td>
    </tr>';
  }
  echo '</table>';
}

include '../footer.php';
?>

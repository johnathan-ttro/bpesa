<?php
//turn off deprecicated warnings
error_reporting(E_ALL ^ E_DEPRECATED);
$page_title = 'BpeSA skills Portal - Assign badges';
require_once '../config.php';
require_once '../header.php';

$currentpage = basename($_SERVER['PHP_SELF']); 
$currentpage = substr($currentpage, 0, -4);

$dbconnect = NEW DB_Class();

$reportPageContentSql = "SELECT pageContent FROM adminpages WHERE pageUrl = '" . $currentpage . "'";
$reportPageContent = $dbconnect->getone($reportPageContentSql);

echo '
  <br/> 
  <h4>Assign vendors/providers badges</h4>
  <br />
  <a href="' . HOSTNAME . 'providers/providers_assign_badges.php">Providers List</a>
  <br />
  <br />
  <a href="' . HOSTNAME . 'vendors/vendors_assign_badges.php">Vendors List</a><br><br>
  <br />
  <br />';


$here = HOSTNAME ; 

include ('../footer.php'); 

?>
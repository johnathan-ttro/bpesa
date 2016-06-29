<?php
//turn off deprecicated warnings
error_reporting(E_ALL ^ E_DEPRECATED);
$page_title = 'BpeSA skills Portal - Manage pages';
require_once '../config.php';
require_once '../header.php';

//get the current page name
$currentpage = basename($_SERVER['PHP_SELF']); 
$currentpage = substr($currentpage, 0, -4);

$dbconnect = NEW DB_Class();

$managePageUrlsSql = "SELECT pageUrl, pageType, pageName, pageOrder FROM adminpages WHERE visible='Y'";
$managePageUrls = $dbconnect->fetch($managePageUrlsSql);

$providerPagesUrlsSql = "SELECT pageUrl, pageType, pageName, pageOrder FROM providerpages";
$providerPagesUrls = $dbconnect->fetch($providerPagesUrlsSql);

$operatorPagesUrlSql = "SELECT pageUrl, pageType, pageName, pageOrder FROM operatorpages";
$operatorPagesUrls = $dbconnect->fetch($operatorPagesUrlSql);

$userPagesUrlsSql = "SELECT pageUrl, pageType, pageName, pageOrder FROM userpages";
$userPagesUrls = $dbconnect->fetch($userPagesUrlsSql);

$providerPageContentSql = "SELECT pageContent FROM adminpages WHERE pageUrl = '" . $currentpage . "'";
$providerPageContent = $dbconnect->getone($providerPageContentSql);

echo '<h1 class="page-title"><span class="current-page">Man</span>age Pages</h1>'.$providerPageContent;
?>

<?php
  echo '
  <h4>Home Page</h4>
  <a href="' . HOSTNAME . 'functions/manage_home_form.php">Home Page</a>
  <br />
  <h4>Administration pages</h4>';
  foreach($managePageUrls as $managePageUrl) {
    echo '<a href="' . HOSTNAME . 'functions/manage_page_form.php?pageType=' . $managePageUrl['pageType'] . '&pageName=' . $managePageUrl['pageName'] . '">' . $managePageUrl['pageName'] . '</a><br />';
  }
  echo '
  <br />
  <h4>Provider Pages</h4>';
  foreach($providerPagesUrls as $providerPagesUrl) {
    echo '<a href="' . HOSTNAME . 'functions/manage_page_form.php?pageType=' . $providerPagesUrl['pageType'] . '&pageName=' . $providerPagesUrl['pageName'] . '">' . $providerPagesUrl['pageName'] . '</a><br />';
  }  
  echo '
  <br />
  <h4>Operator Pages</h4>';
  foreach($operatorPagesUrls as $operatorPagesUrl) {
    echo '<a href="' . HOSTNAME . 'functions/manage_page_form.php?pageType=' . $operatorPagesUrl['pageType'] . '&pageName=' . $operatorPagesUrl['pageName'] . '">' . $operatorPagesUrl['pageName'] . '</a><br />';
  }
  echo '
  <br />
  <h4>User Pages</h4>';
  foreach($userPagesUrls as $userPagesUrl) {
    echo '<a href="' . HOSTNAME . 'functions/manage_page_form.php?pageType=' . $userPagesUrl['pageType'] . '&pageName=' . $userPagesUrl['pageName'] . '">' . $userPagesUrl['pageName'] . '</a><br />';
  }

echo '<br/>
      <br/>';
$here = HOSTNAME ; include ('../footer.php'); ?>
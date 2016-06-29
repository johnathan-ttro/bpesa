<?php
error_reporting(E_ALL ^ E_DEPRECATED);
$page_title = 'BpeSA skills Portal - Manage Pages';
require_once '../config.php';
require_once '../header.php';
include '../sessionTest.php';

$currentpage = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

$dbconnect = NEW DB_Class();

$frontPageContentsSql = 'SELECT content FROM homepage';
$frontPageContents = $dbconnect->getone($frontPageContentsSql);

echo '
<h1 class="page-title"><span class="current-page">Man</span>age Pages</h1>
<form action="' . HOSTNAME . 'functions/manage_home_page_save.php" method="post">
  <textarea name="content">' . $frontPageContents  . '</textarea>
  <br />
  <input type="submit" value="update" class="btn btn-primary">
</form>
<br/>';

include '../footer.php';
?>

<?php
error_reporting(E_ALL ^ E_DEPRECATED);
require_once '../config.php';
include '../sessionTest.php';

if(!empty($_POST)) {

$dbconnect = NEW DB_Class();

  $homePage = $_POST['content'];
  $updateContentpageSql = 'UPDATE homepage SET content="' . mysql_real_escape_string($homePage) . '"';
  $updateContentpage = $dbconnect->query($updateContentpageSql);
  
  if($updateContentpage) {
       header( 'Location: ' . HOSTNAME . 'functions/manage_home_form.php');
    }
}
?>

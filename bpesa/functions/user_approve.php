<?php
//turn off deprecicated warnings
error_reporting(E_ALL ^ E_DEPRECATED);
require_once '../config.php';

$currentPage = $_GET['originUrl'];

if(!empty($_GET)) {

$dbconnect = NEW DB_Class();
  if($_GET['active']== 'Y') {
    $updateUserSql = 'UPDATE users SET active="N" WHERE id= ' . $_GET['userId']  . '';
  }
  if($_GET['active']== 'N') {
    $updateUserSql = 'UPDATE users SET active="Y" WHERE id= ' . $_GET['userId']  . '';
  }
  $updateUser = $dbconnect->query($updateUserSql);
  if($updateUser) {
    header( 'Location: '. HOSTNAME. 'admin/' . $currentPage . '.php');
  }
}
?>

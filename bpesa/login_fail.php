<?php
error_reporting(E_ALL ^ E_DEPRECATED);

$page_title = 'BpeSA skills Portal - Login';
require_once 'config.php';
require_once 'header.php';

if(empty($_SESSION['userName'])){
  echo '<div id="customizedbanner"><h1 class="customizedheading"></h1></div>';
}

echo '
  <div align="center">
    <h1>Your username and password combination is incorrect</h1>
  </div>';

include 'footer.php';
?>

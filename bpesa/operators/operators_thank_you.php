<?php
//turn off deprecicated warnings
error_reporting(E_ALL ^ E_DEPRECATED);
$page_title = 'BpeSA skills Portal - Thank you';
require_once '../config.php';
require_once '../header.php'; 

echo '<h2>You will receive your password at the email address which you registered with.</h2>';

include ('../footer.php'); 
?>

<?php
//turn off deprecicated warnings
error_reporting(E_ALL ^ E_DEPRECATED);
require_once '../config.php';
require_once '../header.php'; 

echo '<h1>The submitted email address does not match those on our system! </h1>';

include ('../footer.php'); 
?>

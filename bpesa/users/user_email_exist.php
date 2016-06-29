<?php
//turn off deprecicated warnings
error_reporting(E_ALL ^ E_DEPRECATED);
require_once '../config.php';
require_once '../header.php'; 

echo 'That email address has already been registered. If you have forgotten your password, <a href="' . HOSTNAME . 'forgot_password.php">click here</a> to have your password sent to you.';

include ('../footer.php'); 
?>

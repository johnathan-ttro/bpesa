<?php
session_start();
if(isset($_SESSION['userName']))
  unset($_SESSION['userName']);

if(isset($_SESSION['userType']))
  unset($_SESSION['userType']);

if(isset($_SESSION['userId']))
  unset($_SESSION['userId']);

 //exit('failure');
 header( 'Location: http://localhost/bpesa/');
?>

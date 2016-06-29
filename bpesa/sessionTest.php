<?php
if (empty($_SESSION['userName'])) {
 //TODO: create the direct url   
  //header( 'Location: http://localhost/BPeSA/loginFailed.php');
    include '../loginFailed.php';
}
?>

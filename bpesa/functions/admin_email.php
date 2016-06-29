<?php
if($_POST['robotStop'] == 'gotYouBot') {
  exit();
} else {
// $to = 'skills@bpesawesterncape.co.za';
$to = 'skills@bpesa.org.za';
$subject = 'Enquirey from the Skills Portal';
$message = "
<html>
  <head>
  <title>BPeSA Email system</title>
  </head>
  <body>
  <p>" . $_POST['comment'] . "</p>
  </body>
  </html>";

  // Always set content-type when sending HTML email
  $headers = "MIME-Version: 1.0" . "\r\n";
  $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";

  // More headers
  $headers .= $_POST['email'];
  mail($to,$subject,$message,$headers);
}
?>
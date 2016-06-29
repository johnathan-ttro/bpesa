<?php
//turn off deprecicated warnings
error_reporting(E_ALL ^ E_DEPRECATED);
require_once '../config.php';
//require_once '../header.php';

$currentPage = $_POST['originUrl'];

$dbconnect = NEW DB_Class();

if(!empty($_POST['userEmail'])) {
        //retrive the details
        $getEmailSql = 'SELECT id FROM users WHERE userEmail="'.  mysql_real_escape_string($_POST['userEmail']) . '"';
        $getEmailresult = $dbconnect->query($getEmailSql);
    
    if (mysql_num_rows($getEmailresult) == 1) { // Retrieve the user ID:
        $getUsersSql = 'SELECT realName, userName, password FROM users WHERE userEmail="'.  mysql_real_escape_string($_POST['userEmail']) . '" LIMIT 1';
        $usersResultList = $dbconnect->fetch($getUsersSql);

        //Send email to the newly registered provider
		
        $to = $_POST['userEmail'];
        $subject = 'Thank you for requesting your password';
        $message = "
        <html>
            <head>
              <title>BPeSA Forgot Password</title>
            </head>

            <body>
                <h3>BPeSA Skills Portal Password Recovery </h3>
                <p>Your password on the BPeSA Skills Portal.</p>";

        foreach($usersResultList as $usersResultLists) {
        $message .= "   <p>Your username is: " . $usersResultLists['userName'] . "</p>
                        <p>Your fullname is: " . $usersResultLists['realName'] . "</p>
                        <p>Your password is: " . $usersResultLists['password'] . "</p>";
        }
        $message .= "
                </body>
              </html>";

        // Always set content-type when sending HTML email
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";

        // More headers
        $headers .= 'From: BPeSA Skills Portal';
        echo $message;
        mail($to,$subject,$message,$headers);
        header( 'Location: '. HOSTNAME . 'users/user_thank_you.php');
    
   } else { // No database match made.
        header( 'Location: '. HOSTNAME . 'users/user_email_fail.php');
  }
    
} else {
    exit('no posted data');
}

?>

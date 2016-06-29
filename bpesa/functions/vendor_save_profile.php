<?php
error_reporting(E_ALL ^ E_DEPRECATED);
require_once '../config.php';

$dbconnect = NEW DB_Class();
$date = date('m/d/Y H:m:s');

// Make sure the email address is available:
$getEmailAddressSql = 'SELECT id FROM users WHERE userEmail="'. $_POST['userEmail'] .'"';
$userEmailAddress = $dbconnect->query($getEmailAddressSql);

if($_POST['bot']){
	echo $_POST['bot'];
	exit;	
}
    
if (mysql_num_rows($userEmailAddress) == 0){ // Available.    
    if(!empty($_POST)){
       $userCompanyProfile = strip_word_html($_POST['userCompanyProfile'] );
       $insertNewVendorSql = "INSERT INTO users (
                            userName,
                            realName,
                            password,
                            userType,
                            userEmail,
                            userCompany,
                            userCompanyProfile,
                            userCategory,
                            userContactNumber,
                            userWebsite,
                            active,
                            lastLogin)
                            VALUES (
                            '" . $_POST['userName'] . "',
                            '" . $_POST['realName'] . "',
                            '" . $_POST['password'] . "',
                            'vendors',
                            '" . $_POST['userEmail']  . "',
                            '" . $_POST['userCompany']  . "',
                            '" . $userCompanyProfile  . "',
                            '" . $_POST['userCategory']  . "',
                            '" . $_POST['userContactNumber']  . "',
                            '" . $_POST['userWebsite']  . "',
                            'Y',
                            '" . $date . "')";
      $insertNewVendor = $dbconnect->query($insertNewVendorSql);

      if($insertNewVendor) {
      header( 'Location: '. HOSTNAME . 'providers/providers_thank_you.php');
      }  
    }
}else { // The email address is not available.
       header( 'Location: ' . HOSTNAME . '/vendors/vendors_email_exist.php');
}
?>

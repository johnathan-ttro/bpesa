<?php
error_reporting(E_ALL ^ E_DEPRECATED);
require_once '../config.php';
//require_once '../menu.php';
//require_once '../header.php';

$currentPage = $_POST['originUrl'];
$date = date('m/d/Y H:m:s');

if(!empty($_POST)) {
  //image Upload and manipluation  
  require('simpleImage.php');
  $allowedExts = array("gif", "jpeg", "jpg", "png");
  $temp = explode(".", $_FILES["companyLogo"]["name"]);
  $extension = end($temp);
  if ((
    ($_FILES["companyLogo"]["type"] == "image/gif")
    || ($_FILES["companyLogo"]["type"] == "image/jpeg")
    || ($_FILES["companyLogo"]["type"] == "image/jpg")
    || ($_FILES["companyLogo"]["type"] == "image/pjpeg")
    || ($_FILES["companyLogo"]["type"] == "image/x-png")
    || ($_FILES["companyLogo"]["type"] == "image/png"))
    && ($_FILES["companyLogo"]["size"] < 900000)
    && in_array($extension, $allowedExts)){
    if ($_FILES["companyLogo"]["error"] > 0) {
      echo "Return Code: " . $_FILES["companyLogo"]["error"] . "<br>";
      //exit();
    } else {
    if (file_exists("../images/providerlogos/" . $_FILES["companyLogo"]["name"])){
      echo $_FILES["companyLogo"]["name"] . " already exists. ";
      exit();
    } else {  
      move_uploaded_file($_FILES["companyLogo"]["tmp_name"],
      "../images/providerlogos/" . $_FILES["companyLogo"]["name"]);
      
      $companyLogo = HOSTNAME . "/images/resized_logo/" . $_FILES["companyLogo"]["name"];
      
      /***Image resize    ***/
      $directory = "../images/providerlogos/";
      if (is_dir($directory)) {
      if ($directoryOpen = opendir($directory)) {
      $images = array(); //fetch images and sort in array for manipulating
   
      while (($file = readdir($directoryOpen)) !== false) {
        if (!is_dir($directory.$file)) {
          $images[] = $file ;//fetch images	
	  $image = new SimpleImage(); // create new class from  SimpleImage.php 
	  $image->load('../images/providerlogos/' . $file . ''); //load all the uploaded images
	  $image->scale(50);  //scale images for appropriate file compression 			
				
	   // Do a check for image aspect ratios and scale accordingly so no images distort
	   if($image->getWidth($file) > 150 ){			
             $image->resizeToWidth(150);
	     $image->save('../images/resized_logo/'.$file.'');				
	   } elseif ($image->getHeight($file) < 150){
	     $image->resizeToHeight(150);
	     $image->save('../images/resized_logo/'.$file.'');
           } else {
             throw new Exception('An error in the image processing has occurred.');
	   }				 
	 }		
       }                  
       //Delete files in the large upload image folder
       $content = glob('../images/providerlogos/*'); // get all file names
       foreach($content as $content){ // iterate files
         if(is_file($content))
	         unlink($content); // delete file
         }
        }
       closedir($directoryOpen);
      }
      
      /***End Image resize ***/
      $imageSubmitted = true;
     
      }
    } 
  } else {
    //echo ("Invalid file");
    $imageSubmitted = true;
    $companyLogo = 'no image';
  }
    
 // end image upload   
  $dbconnect = NEW DB_Class();

  // Make sure the email address is available:
  $getEmailAddressSql = 'SELECT id FROM users WHERE userEmail="'. $_POST['email'] .'"';
  $userEmailAddress = $dbconnect->query($getEmailAddressSql);
    
  if (mysql_num_rows($userEmailAddress) == 0){ // Available.
      
  if($imageSubmitted) {
    $companyProfile = strip_word_html($_POST['companyProfile']);
    
    $insertNewProviderLoginSql = 'INSERT INTO users (userName, realName, userCompany, userContactNumber, userEmail, userWebsite, userCompanyProfile, userCategory, password, userType, active, lastLogIn) 
                                  VALUES ("' . $_POST['userName'] . '",  "' . $_POST['contactName'] . '", "' . $_POST['companyName'] . '" , "' . $_POST['contactNumber'] . '", "' . $_POST['email'] . '","' . $_POST['companyWebsite'] . '", "' . mysql_real_escape_string($companyProfile) . '", "'. $_POST['trainingCatergory'] .'","' . $_POST['password'] . '", "provider", "Y","'. $date .'")';
    $insertNewProviderLogin = $dbconnect->query($insertNewProviderLoginSql);
    
    $getNewUserIdSql= "SELECT id FROM users WHERE userName = '" . $_POST['userName'] . "' AND password = '" . $_POST['password']  . "'";
    $getNewUser = $dbconnect->getone($getNewUserIdSql);
      
    $insertNewProviderSql = 'INSERT INTO providers 
                             (userID,
                              companyName, 
                              contactPerson, 
                              email, 
                              contactNumber, 
                              location, 
                              companyLogo,  
                              website, 
                              StartDate, 
                              active, 
                              approved, 
                              customTrainingCategory)
                             VALUES (
                             ' . $getNewUser . ',
                             "' . $_POST['companyName'] . '", 
                             "' . $_POST['contactName'] . '", 
                             "' . $_POST['email'] . '",
                             "' . $_POST['contactNumber'] . '", 
                             "' . $_POST['location'] . '", 
                             "' . $companyLogo . '", 
                             "' . $_POST['companyWebsite'] . '",
                             "' . date('Y-m-d')  . '", 
                             "Y", 
                             "Y", 
                             "' . $_POST['trainingCatergory'] . '")';
    $insertNewProvider = $dbconnect->query($insertNewProviderSql);
    
    //Send email to the newly registered provider  
    $to = $_POST['email'];
    $subject = 'Thank you for registering as a provider';
    $message = "
    <html>
      <head>
        <title>BPeSA Registration</title>
      </head>
    <body>
      <h3>Welcome to the BPeSA Skills Portal</h3>
      <p>You have been successfully registered as a provider on the BPeSA Skills Portal.</p>
      <table>
      <p>Your username is: " . $_POST['userName'] . "</p>
      <p>Your username is: " . $_POST['password'] . "</p>
    </body>
    </html>";

    // Always set content-type when sending HTML email
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";

    //More headers
    $headers .= 'From: BPeSA Skills Portal';

    mail($to,$subject,$message,$headers);
    header( 'Location: '. HOSTNAME . 'providers/providers_thank_you.php');
  }
    header( 'Location: ' . HOSTNAME . 'providers/providers_thank_you.php');
    
   }else { // The email address is not available.
    header( 'Location: ' . HOSTNAME . 'providers/providers_email_exist.php');
  }
}

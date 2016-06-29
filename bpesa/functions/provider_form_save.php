<?php
//turn off deprecicated warnings
error_reporting(E_ALL ^ E_DEPRECATED);
require_once '../config.php';

$currentPage = $_POST['originUrl'];

$dbconnect = NEW DB_Class();
  
if(!empty($_POST)) {
  //save the image
  require('simpleImage.php');
  $allowedExts = array("gif", "jpeg", "jpg", "png");
  $temp = explode(".", $_FILES["companyLogo"]["name"]);
  $extension = strtolower(end($temp));
  
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
      exit();
    } else {
    if (file_exists("../images/providerlogos/" . $_FILES["companyLogo"]["name"])){
      echo $_FILES["companyLogo"]["name"] . " already exists. ";
      exit();
    } else {  
      move_uploaded_file($_FILES["companyLogo"]["tmp_name"],
      "../images/providerlogos/" . $_FILES["companyLogo"]["name"]);
      
      $companyLogo = HOSTNAME . "images/resized_logo/" . $_FILES["companyLogo"]["name"];
      
      /***Image resize    ***/
            //$directory = "http://www.bpesaskillsportal.co.za/images/providerLogos/";
	  //echo getcwd();
	  $directory = "../images/providerlogos/";
	
	  //$directory = "/var/www/html/images/providerLogos/";
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
      } else {
	     exit('directory not found');
	    } 
      /***End Image resize ***/
      $imageSubmitted = true;
     
      }
    } 
  } else {
     ("Invalid files");
    $imageSubmitted = false;
  }
  
  /*upload the validation documents in PDF format*/
  $file_type = $_FILES['accreditaton']['type']; //returns the mimetype

  $allowed = array("application/pdf", "application/msword","application/vnd.openxmlformats-officedocument.wordprocessingml.document" );
  if(in_array($file_type, $allowed)) {
    move_uploaded_file($_FILES["accreditaton"]["tmp_name"],
      "../validationDocuments/" . $_FILES["accreditaton"]["name"]);
  }
  
  if(!empty($_POST['trainingCategoriesOther'])) {
    $trainingCatergory = $_POST['trainingCategoriesOther'];
  } else {
    $trainingCatergory = 'NA';
    if($_POST['trainingCategories'] != 'other') {
      $updateTrainingCategoriesSql = 'INSERT INTO training_categories_link (trainingCategorieId, providerId) VALUES (' . $_POST['trainingCategories'] . ', ' . $_POST['userId']. ')';
      $updateTrainingCategories = $dbconnect->query($updateTrainingCategoriesSql);
      $trainingCatergory = $_POST['trainingCategories'];
    }
  }
 

  if($imageSubmitted) {
    $companyProfile = strip_word_html($_POST['companyProfile']);
    $bankDetails = strip_word_html($_POST['bankDetails']);  

    $updatepagesSql = 'UPDATE providers SET 
                       companyName="' . $_POST['companyName'] . '", 
                       contactPerson="' . $_POST['contactName'] . '",
                       email="' . $_POST['email'] . '",
                       contactNumber="' . $_POST['contactNumber'] . '",
                       location="' . $_POST['location'] . '",
                       companyLogo="' . $companyLogo . '",
                       bankDetails = "' . mysql_real_escape_string($bankDetails) . '",
                       website="' . $_POST['companyWebsite'] . '",
                       customTrainingCategory = "' . $trainingCatergory . '"
                       WHERE userId= ' . $_POST['userId'] . '';
    
    $userNameUpdateSql= 'UPDATE users SET realName = "' . $_POST['contactName'] .  '", userCompanyProfile = "' . mysql_real_escape_string($companyProfile) . '" WHERE id="' . $_POST['userId'] . '"';
  } else {
    $companyProfile = strip_word_html($_POST['companyProfile']);
    $bankDetails = strip_word_html($_POST['bankDetails']);  

    $updatepagesSql = 'UPDATE providers SET 
                       companyName="' . $_POST['companyName'] . '", 
                       contactPerson="' . $_POST['contactName'] . '",
                       email="' . $_POST['email'] . '",
                       bankDetails="' . mysql_real_escape_string($bankDetails) . '",
                       contactNumber="' . $_POST['contactNumber'] . '",
                       location="' . $_POST['location'] . '",
                       website="' . $_POST['companyWebsite'] . '",
                       customTrainingCategory = "' . $trainingCatergory . '"
                       WHERE userId="' . $_POST['userId'] . '"';  
    
    $userNameUpdateSql = 'UPDATE users SET realName = "' . $_POST['contactName'] .  '", userCompanyProfile = "' . mysql_real_escape_string($companyProfile) . '" WHERE id="' . $_POST['userId'] . '"';
  }
    
  $updatepagesSave = $dbconnect->query($updatepagesSql);
  $userNameUpdate = $dbconnect-> query($userNameUpdateSql);
  if($_FILES["accreditaton"]["name"] != '') {
  $accreditationExpiarySql = "INSERT INTO accreditationdocuments (documentName, providerId, documentUrl, expiaryDate) 
                              VALUES ('" . $_FILES["accreditaton"]["name"] . "', " . $_POST['userId'] . ", 
                                     '" . HOSTNAME . "validationDocuments/" . $_FILES["accreditaton"]["name"] . "',
                                     '"  . $_POST['accreditatonExpire'] . "')";

  $accreditationExpiary = $dbconnect->query($accreditationExpiarySql);
  }
  if($updatepagesSave) {
    header( 'Location: '. HOSTNAME . 'providers/' . $currentPage . '.php');
  }
} else {
  exit('no posted data');
}
?>

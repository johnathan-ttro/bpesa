<?php
//turn off deprecicated warnings
error_reporting(E_ALL ^ E_DEPRECATED);
require_once '../config.php';
include '../sessionTest.php';
$date = date('m/d/Y H:m:s');

$dbconnect = NEW DB_Class();

$currentPage = $_POST['originUrl'];

$imageSubmitted = false;

  /***Image resize ***/ 
  require('simpleImage.php');
  $allowedExts = array("gif", "jpeg", "jpg", "png");
  $temp = explode(".", $_FILES["profileImage"]["name"]);
  $extension = end($temp);
  if ((($_FILES["profileImage"]["type"] == "image/gif")
    || ($_FILES["profileImage"]["type"] == "image/jpeg")
    || ($_FILES["profileImage"]["type"] == "image/jpg")
    || ($_FILES["profileImage"]["type"] == "image/pjpeg")
    || ($_FILES["profileImage"]["type"] == "image/x-png")
    || ($_FILES["profileImage"]["type"] == "image/png"))
    && ($_FILES["profileImage"]["size"] < 900000)
    && in_array($extension, $allowedExts)){
    echo $_FILES["profileImage"]["name"];
    if ($_FILES["profileImage"]["error"] > 0) {
      echo "Return Code: " . $_FILES["profileImage"]["error"] . "<br>";
      //exit();
    } else {
    if (file_exists("../images/providerLogos/" . $_FILES["profileImage"]["name"])){
      echo $_FILES["profileImage"]["name"] . " already exists. ";
      exit();
    } else { 
        
      echo $info = pathinfo($_FILES['profileImage']['name']);
      $ext = $info['extension'];  
      $renamedImage = strtotime($date) . "." . $ext;  
      
      move_uploaded_file($_FILES["profileImage"]["tmp_name"],
      "../images/providerLogos/" . $renamedImage);
     
      echo $profileImage = HOSTNAME . "images/resized_profilepix/" . $renamedImage;
      
      /***Image resize***/
      $directory = "../images/providerLogos/";
      if (is_dir($directory)) {
      if ($directoryOpen = opendir($directory)) {
      $images = array(); //fetch images and sort in array for manipulating
   
      while (($file = readdir($directoryOpen)) !== false) {
        if (!is_dir($directory.$file)) {
          $images[] = $file ;//fetch images	
      	  $image = new SimpleImage(); // create new class from  SimpleImage.php 
      	  $image->load('../images/providerLogos/' . $file . ''); //load all the uploaded images
      	  $image->scale(250);  //scale images for appropriate file compression 			
				
	   // Do a check for image aspect ratios and scale accordingly so no images distort
	   if($image->getWidth($file) > 250 ){			
          $image->resizeToWidth(250);
  	      $image->save('../images/resized_profilepix/'.$file.'');				
	   } elseif ($image->getHeight($file) < 250){
  	      $image->resizeToHeight(250);
  	      $image->save('../images/resized_profilepix/'.$file.'');
        } else {
             throw new Exception('An error in the image processing has occurred.');
	      }				 
	 }		
       }                  
       //Delete files in the large upload image folder
       $content = glob('../images/providerLogos/*'); // get all file names
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
    $imageSubmitted = false;
 } 
 //end image upload 
$profileImageUrl = $_POST['profileImg'];

if(!empty($_POST)){

 if(empty($_POST['profileImage'])){
   $profileImageUrl = $_POST['profileImg'];
 }else{
   $profileImageUrl = $profileImage;
 }  

 $updateUsersSql = "UPDATE users 
                           SET  
                           realName='" . $_POST['name'] . ' ' .$_POST['surName'] ."',
                           userEmail='" . $_POST['email']  . "',
                           userContactNumber='" . $_POST['ContactNumber']  . "'
                           WHERE id=" . $_SESSION['userId'];
  $updateUserProfile = $dbconnect->query($updateUsersSql);
  
 
  if(($employmentstatus = $_POST['employmentStatus']) == 'no'){
      $companyemployed = '';
      $position = '';
  }else{
      $companyemployed = $_POST['employmentCompany'];
      $position = $_POST['position'];
  }
  
$learnersProfilesSql = 'SELECT id FROM leaners WHERE userID = ' . $_SESSION['userId'] .'';
$learnersProfiles= $dbconnect->getone($learnersProfilesSql);

if(!empty($learnersProfiles)) {
    echo $updateLeanersSql = "UPDATE leaners 
                                 SET 
                                 name='" . $_POST['name'] . "',
                                 surName='" . $_POST['surName']  . "',
                                 idNumber='" . $_POST['idNumber']  . "',
                                 employmentStatus='" . $_POST['employmentStatus']  . "',
                                 learnerCompanyEmployed='" . $companyemployed  . "',
                                 position='" . $position  . "',
                                 learnerHighestEducation = '" . $_POST['highestEducation'] . "',
                                 profileImageOriginalName = '" . $_FILES["profileImage"]["name"] . "',   
                                 profileImage = '" . $profileImageUrl  . "' 
                                 WHERE userID=" . $_SESSION['userId'];

}else{
   $updateLeanersSql = "INSERT INTO leaners
                              (userID,
                               name, 
                               surName,
                               idNumber, 
                               employmentStatus, 
                               learnerCompanyEmployed, 
                               position, 
                               learnerHighestEducation, 
                               profileImageOriginalName, 
                               profileImage) 
                                VALUES 
                                 (" . $_SESSION['userId'] . ",
                                 '" . $_POST['name'] . "',
                                 '" . $_POST['surName']  . "',
                                 '" . $_POST['idNumber']  . "',
                                 '" . $_POST['employmentStatus']  . "',
                                 '" . $companyemployed  . "',
                                 '" . $position  . "',
                                 '" . $_POST['highestEducation'] . "',
                                 '" . $_FILES["profileImage"]["name"] . "',   
                                 '" . $profileImage  . "')";
}
$updateLeaners = $dbconnect->query($updateLeanersSql);
  
if($updateUserProfile) {
    //header( 'Location: '. HOSTNAME. 'users/' . $currentPage . '.php');
}  

}
?>

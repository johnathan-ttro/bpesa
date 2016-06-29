<?php
error_reporting(E_ALL ^ E_DEPRECATED);
require_once '../config.php';

$dbconnect = NEW DB_Class();
$date = date('m/d/Y H:m:s');

if(!empty($_POST)){
  //image Upload and manipluation  
  require('simpleImage.php');
  $allowedExts = array("gif", "jpeg", "jpg", "png");
  $temp = explode(".", $_FILES["companyLogo"]["name"]);
  $extension = end($temp);
  if ((($_FILES["companyLogo"]["type"] == "image/gif")
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

  if(empty($_FILES["companyLogo"]["name"])){
     $companyLogo = $_POST['imageUrl'];
  }

  $companyProfile = strip_word_html($_POST['companyProfile']);
  $updateOperatorpagesSql = 'UPDATE users SET 
                               userCompany="' . $_POST['companyName'] . '",
                               userCompanyProfile="' . mysql_real_escape_string($companyProfile) . '",
                               userWebsite="' . $_POST['companyWebsite'] . '"
                               WHERE id=' . $_POST['userId'] . '';

  $updateOperatorpagesSave = $dbconnect->query($updateOperatorpagesSql);
   
  $selectRegionNamesSql = 'DELETE FROM region_links WHERE userId =' . $_POST['userId'] . '';
  $dbconnect->query($selectRegionNamesSql);
   
  foreach($_POST['regionNames'] as $regionId){ 
    $updateRegionNamesSql= 'INSERT INTO region_links (regionId , userId ) VALUES (' . $regionId .  ', ' .  $_POST['userId'] . ')';
    $dbconnect->query($updateRegionNamesSql);
  }

  $updateOperatorSql = 'UPDATE operators SET 
                       companyName="' . $_POST['companyName'] . '",
                       companyLogo="' . $companyLogo . '",
                       bankDetails = "' . mysql_real_escape_string($bankDetails) . '",
                       website="' . $_POST['companyWebsite'] . '"
                       WHERE userId= ' . $_POST['userId'] . '';
  $updateOperatorSave = $dbconnect->query($updateOperatorSql);

  if($updateOperatorpagesSave) {
    header( 'Location: '. HOSTNAME . 'operators/' . $_POST['originUrl'] . '.php');
  }  
}


?>

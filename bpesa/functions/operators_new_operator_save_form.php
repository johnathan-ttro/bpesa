<?php
error_reporting(E_ALL ^ E_DEPRECATED);
require_once '../config.php';

$dbconnect = NEW DB_Class();
$date = date('m/d/Y H:m:s');

if(!empty($_POST)){
        
   $insertNewOperatorLoginSql = 'INSERT INTO users (userName, realName, password, userType, userEmail, userCompany, userCompanyProfile, userContactNumber, userWebsite, active, lastLogin) 
                                 VALUES("' . $_POST['userName'] .'",
                                        "' . $_POST['name'] . ' ' . $_POST['surName'] .  '" ,  
                                        "' . $_POST['password'] . '",
                                        "operators",
                                        "' . $_POST['email'] . '",
                                        "' . $_POST['companyName'] . '",
                                        "' . $_POST['companyProfile'] . '",
                                        "' . $_POST['contactNumber'] . '",    
                                        "' . $_POST['companyWebsite'] . '",
                                        "Y",
                                        "' . $date . '")';
   $insertNewOperatorLogin = $dbconnect->query($insertNewOperatorLoginSql);

   $getNewOperatorIdSql= "SELECT id FROM users WHERE userName = '" . $_POST['userName'] . "' AND password = '" . $_POST['password']  . "'";
   $NewOperatorId = $dbconnect->getone($getNewOperatorIdSql);
    
   $insertNewContactPersonSql = "INSERT INTO contact_person(
                                userID,
                                name,
                                surName,
                                contactNumber,
                                email,
                                date)
                                VALUES (
                                '" . $NewOperatorId . "',
                                '" . $_POST['name'] . "',
                                '" . $_POST['surName'] . "',
                                '" . $_POST['contactNumber'] . "',
                                '" . $_POST['email'] . "',
                                '" . $date . "')";
   $insertNewContactPerson = $dbconnect->query($insertNewContactPersonSql);
   
   $insertNewOperatorSql = 'INSERT INTO operators 
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
                             ' . $NewOperatorId . ',
                             "' . $_POST['companyName'] . '", 
                             "' . $_POST['name'] . ' ' . $_POST['surName'] .  '" , 
                             "' . $_POST['email'] . '",
                             "' . $_POST['contactNumber'] . '", 
                             "' . $_POST['location'] . '", 
                             "' . $companyLogo . '", 
                             "' . $_POST['companyWebsite'] . '",
                             "' . date('Y-m-d')  . '", 
                             "Y", 
                             "Y", 
                             "' . $_POST['trainingCatergory'] . '")';
   $dbconnect->query($insertNewOperatorSql);

   foreach($_POST['regionNames'] as $regionId){
        $insertNewRegionNamesSql = 'INSERT INTO region_links ( regionId , userId ) values ("' . $regionId . '" , "' . $NewOperatorId . '")';
        $dbconnect->query($insertNewRegionNamesSql);
   }

   if($insertNewContactPerson) {
      header( 'Location: '. HOSTNAME . 'operators/operators_thank_you.php');
   }  
}


?>

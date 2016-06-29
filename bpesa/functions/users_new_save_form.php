<?php
error_reporting(E_ALL ^ E_DEPRECATED);
require_once '../config.php';

$dbconnect = NEW DB_Class();
$date = date('m/d/Y H:m:s');

//make sure the email address is available:
$getLearnerEmailSql = 'SELECT id FROM users WHERE userEmail="'. $_POST['email'] .'"';
$learnerEmail = $dbconnect->query($getLearnerEmailSql);
    
if (mysql_num_rows($learnerEmail) == 0){ // Available.  
   if(!empty($_POST)){
        
   $insertNewLearnerLoginSql = 'INSERT INTO users (realName, userEmail, userContactNumber, userName, password, userType, active) 
                                VALUES ("' . $_POST['name'] . ' '. $_POST['surName'] . '",
                                        "' . $_POST['email'] . '" ,  
                                        "' . $_POST['ContactNumber'] . '",
                                        "' . $_POST['userName'] . '",
                                        "' . $_POST['password'] . '",
                                        "users",
                                        "Y")';
   $insertNewLearnerLogin = $dbconnect->query($insertNewLearnerLoginSql);
   
   $getNewUserIdSql= "SELECT id FROM users WHERE userName = '" . $_POST['userName'] . "' AND password = '" . $_POST['password']  . "'";
   $getNewUser = $dbconnect->getone($getNewUserIdSql);
    
   $insertNewLearnerSql = "INSERT INTO leaners(
                            userID,
                            name,
                            surName,
                            idNumber,
                            currentStatus,
                            employmentStatus,
                            learnerCompanyEmployed,
                            position,
                            learnerHighestEducation)
                            VALUES (
                            '" . $getNewUser . "',
                            '" . $_POST['name'] . "',
                            '" . $_POST['surName'] . "',
                            '" . $_POST['idNumber'] . "',
                            '" . $_POST['currentStatus'] . "',
                            '" . $_POST['employmentStatus'] . "',
                            '" . $_POST['employmentCompany'] . "',
                            '" . $_POST['position'] . "',
                            '" . $_POST['highestEducation']  . "')";
       
      $insertNewUser = $dbconnect->query($insertNewLearnerSql);

      if($insertNewUser) {
        header( 'Location: '. HOSTNAME . 'users/user_thank_you.php');
      }  
    }
}else { // The email address is not available.
       header( 'Location: ' . HOSTNAME . 'users/user_email_exist.php');
}

?>

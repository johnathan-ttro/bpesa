<?php
error_reporting(E_ALL ^ E_DEPRECATED);
require_once '../config.php';

$currentPage = $_POST['originUrl'];

$dbconnect = NEW DB_Class();

if(isset($_POST['NewCourse'])) { 
  //check to see if they have a payment gateway account
  $paymentGateWayCheckSql = 'SELECT merchantId FROM provider_payment_gateway WHERE providerId = ' . $_POST['id'];
  $paymentGateWayCheck = $dbconnect->fetch($paymentGateWayCheckSql);
  
  if(!($paymentGateWayCheck)) {
    $insertNAStatusSql = 'INSERT INTO provider_payment_gateway (providerId, merchantId, merchantKey)
                          VALUES (' . $_POST['id'] . ', "N/A", "N/A")' ;
    $insertNAStatus = $dbconnect->query($insertNAStatusSql);
  } 
  //strip out all the strange MS-wprd formatting
  $courseDescription = strip_word_html($_POST['courseDescription']); 
  $insertCourseSql = 'INSERT INTO courses (courseName, courseDetails, courseStartDate, courseEndDate, providerId, capacity, coursePrice, province, courseLocation, online, status) 
                        VALUES ("' . $_POST['courseName'] . '", 
                                "' . mysql_real_escape_string($courseDescription) . '",
                                "' . $_POST['courseStartDate'] . '", 
                                "' . $_POST['courseEndDate'] . '", 
                                 ' . $_POST['id'] . ',
                                 ' . $_POST['courseCapacity'] . ', 
                                "' . $_POST['coursePrice'] . '",
                                "' . $_POST['province'] . '",
                                "' . $_POST['courseLocation'] . '",
								                "' . $_POST['online'] . '",
                                "Y")';
    
  $insertCourseSave = $dbconnect->query($insertCourseSql);
  if($insertCourseSave) {
    header( 'Location: '. HOSTNAME . 'providers/' . $currentPage . '.php');
  }
} elseif(isset($_POST['updateCourse'])) {
  $courseDescription = strip_word_html($_POST['courseDetails']);
  //Update a course that already exists
  $updateCourseSql = 'UPDATE courses SET 
                      courseDetails = "' . mysql_real_escape_string($courseDescription) . '",
                      courseStartDate = "' . $_POST['courseStartDate'] . '",
                      courseEndDate = "' . $_POST['courseEndDate'] . '",
                      capacity = ' . $_POST['courseCapacity'] . ',
                      coursePrice = "' . $_POST['coursePrice'] . '",
                      province = "' . $_POST['province'] . '",
                      courseLocation = "' . $_POST['courseLocation'] . '"
                      WHERE id = ' . $_POST['courseId'];
  $updateCourse = $dbconnect->query($updateCourseSql);
  
  if($updateCourse) {
    header( 'Location: '. HOSTNAME . 'providers/' . $_POST['originUrl'] . '.php?course=' . $_POST['courseId'] . '');
  } 
                       
} elseif (!empty($_GET)) {
  $currentPage = $_GET['orginUrl'];
  if($_GET['status'] == 'Y') {
      $statusUpdate = 'N';
  } elseif ($_GET['status'] == 'N') {
      $statusUpdate = 'Y';
  } else {
      exit('No status set, please contact the administrator');
  }
  
  $updateCourseActiveSql = 'UPDATE courses SET status="' . $statusUpdate . '" WHERE id = ' . $_GET['courseid'];
  $updateCourseActive = $dbconnect->query($updateCourseActiveSql);
  
  if($updateCourseActive) {
       header( 'Location: '. HOSTNAME . 'providers/' . $currentPage . '.php');
    }
} else {
    exit('No data');
}
?>

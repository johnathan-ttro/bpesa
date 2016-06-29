<?php
error_reporting(E_ALL ^ E_DEPRECATED);
require_once '../config.php';
include '../sessionTest.php';

if($_POST['userId'] != '' && $_POST['courseId'] != '') {

$dbconnect = NEW DB_Class(); 

  $userBookingSql = 'INSERT INTO user_booking_link (userId, courseId, numberOfAttendees) VALUES (' . $_POST['userId'] . ',' . $_POST['courseId'] . ',' . $_POST['numberOfbookings']. ')';
  $userBooking = $dbconnect->query($userBookingSql);
  
  if($userBooking) {
    header( 'Location: '. HOSTNAME . 'users/user_courses.php');  
  }
} else {
    die('no data posted');
}
?>
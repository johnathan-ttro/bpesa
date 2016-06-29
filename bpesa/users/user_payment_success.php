<?php
error_reporting(E_ALL ^ E_DEPRECATED);
require_once '../config.php';
include '../sessionTest.php';

if($_POST['custom_int1'] != '' && $_POST['custom_int2'] != '') {

$dbconnect = NEW DB_Class();
  $userBookingSql = 'INSERT INTO user_booking_link (userId, courseId, numberOfAttendees) VALUES (' . $_POST['custom_int1'] . ',' . $_POST['custom_int2'] . ',' . $_POST['custom_int3']. ')';
  $userBooking = $dbconnect->query($userBookingSql);
  
  if($userBooking) {
    header( 'Location: '. HOSTNAME . 'users/user_courses.php');  
  }
} else {
    die('no data posted');
}
?>

<?php
error_reporting(E_ALL ^ E_DEPRECATED);
require_once '../config.php';

$currentPage = $_GET['orginUrl'];

$dbconnect = NEW DB_Class();

if($_GET['DeleteCourse']=='true') { 

$courseid = $_GET['courseId'];

$deleteBookingsSql = "DELETE FROM user_booking_link WHERE courseId='".$courseid."'";

$deleteBookings = $dbconnect->query($deleteBookingsSql);

$deleteCourseSql = "DELETE FROM courses WHERE id='".$courseid."'";

	//echo $deleteCourseSql;

	$deleteCourse = $dbconnect->query($deleteCourseSql);

  if($deleteCourse&&$deleteBookings) {
    header( 'Location: '. HOSTNAME . 'providers/' . $currentPage . '.php');
  }

} else {
    exit('No data');
}
?>

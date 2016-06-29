<?php
error_reporting(E_ALL ^ E_DEPRECATED);
$page_title = 'BpeSA skills Portal - Courses';
require_once '../config.php';
require_once '../header.php';
require_once 'user_calendarlib.php';
?>

<!-- FULLSCREEN MENU CODE (.fullscreen) -->
<div class="container-fluid" style="padding-top:26px !important">
  <div class="row">
        <div class="col-md-12"  style="margin-bottom:20px !important">
      <h1 class="page-title"><span class="current-page">Cal</span>endar</h1>
    </div>
<div class="col-lg-12">

<?php
$width = 100/7;
//check to see if the user is logged in and display information appropriate to them
if($_SESSION['userName'] != '') {
  //show user booked sessions  
  $usersBookedCoursesSql = "SELECT 
                            user_booking_link.userId, 
                            user_booking_link.courseId,
                            users.id, 
                            courses.courseName,
                            courses.province,
                            courses.courseLocation, 
                            courses.courseStartDate,
                            courses.courseEndDate
                            FROM user_booking_link
                            INNER JOIN users ON user_booking_link.userId = users.id
                            INNER JOIN courses ON user_booking_link.courseId = courses.id
                            INNER JOIN vendor_link ON courses.id = vendor_link.courseId
                            INNER JOIN vendors ON vendor_link.vendorId = vendors.id
                            WHERE courses.status= 'Y'
                            AND courses.archived !='Y'
                            AND user_booking_link.userId = " . $_SESSION['userId'] . $where ;
  
  $usersBookedCourses = $dbconnect->fetch($usersBookedCoursesSql); 

  if($usersBookedCourses != null) {
      $courseExcludeArray = '';
      foreach($usersBookedCourses as $usersBookedCourse) {
        $courseExcludeArray.=  $usersBookedCourse['courseId'] . ',';
      }
      //Get the courses that the user hasnt booked yet
      $courseExcludeArray = rtrim($courseExcludeArray, ",");
      $courseListSql = "SELECT courses.id, 
                               courses.courseName, 
                               courses.province,
                               courses.courseLocation, 
                               courses.courseStartDate, 
                               courses.courseEndDate, 
                               courses.coursePrice,
                               providers.companyName,
                               providers.badge,
                               vendors.vendorLocation, 
                               vendors.province
                               FROM courses
                               INNER JOIN providers ON courses.providerId = providers.userID
                               INNER JOIN vendor_link ON courses.id = vendor_link.courseId
                               INNER JOIN vendors ON vendor_link.vendorId = vendors.id
                               WHERE status='Y' 
                               AND courses.id NOT IN (" . $courseExcludeArray  . ")
                               AND courses.archived !='Y'
                               AND courses.venueBooked ='Y'";
      $courseLists = $dbconnect->fetch($courseListSql);
    }

}

$calendar = new donatj\SimpleCalendar(); 
$calendar->setStartOfWeek('Sunday');

if(null==$yearString&&isset($_GET['year'])){
  $yearString = $_GET['year'];
}else if(null==$yearString){
    $yearString = date("Y",time());  
}          
 
if(null==$monthString&&isset($_GET['month'])){
    $monthString = $_GET['month'];
}else if(null==$monthString){
    $monthString = date("m",time());
}

if(null==$dayString){
  $dayString = date("d",time());
}

foreach($usersBookedCourses as $usersBookedCourse) {

  $courseName = $usersBookedCourse['courseName'];

  $courseStartDate = $usersBookedCourse['courseStartDate'];
  $courseEndDate = $usersBookedCourse['courseEndDate'];

  list($date, $month, $year) = explode('/', $courseStartDate);// split on underscore.
  $courseStartDate = $date .'-'. $month .'-'. $year; 

  list($date, $month, $year) = explode('/', $courseEndDate);// split on underscore.
  $courseEndDate = $date .'-'. $month .'-'. $year;

  $calendar->addDailyHtml('<a href="' . HOSTNAME . 'users/user_book_course.php?courseId=' . $usersBookedCourse['courseId'] . '&userId=' .  $_SESSION['userId'] . '&booked=Y" class="courseinfo">'. $courseName . '<hr>START</a>', $courseStartDate );
  $calendar->addDailyHtml('<a href="' . HOSTNAME . 'users/user_book_course.php?courseId=' . $usersBookedCourse['courseId'] . '&userId=' .  $_SESSION['userId'] . '&booked=Y" class="courseinfo">'. $courseName . '<hr>END</a>', $courseEndDate );

  $continueStartDate = strtotime($courseStartDate .'+1 day');
  $continueEndDate =  strtotime($courseEndDate .'-1 day');

  for($i = $continueStartDate; $i <= $continueEndDate; $i = $i + 86400) {
      $continueDate = date('d-m-Y', $i);
      $calendar->addDailyHtml('<a href="' . HOSTNAME . 'users/user_book_course.php?courseId=' . $usersBookedCourse['courseId'] . '&userId=' .  $_SESSION['userId'] . '&booked=Y" class="courseinfo">' . $courseName . '</a>', $continueDate);
  }   
 
}

$calendar->setDate($yearString . '-'. $monthString .'-' . $dayString);
$calendar->show(true);

?>



</div>
    
  </div>
</div>

<?php
include '../footer.php'; 
?>

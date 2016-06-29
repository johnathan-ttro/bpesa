<?php
//turn off deprecicated warnings
error_reporting(E_ALL ^ E_DEPRECATED);
$page_title = 'BpeSA skills Portal - Courses';
require_once '../config.php';
require_once '../header.php';

$currentpage = basename($_SERVER['PHP_SELF']); 
$currentpage = substr($currentpage, 0, -4);

$dbconnect = NEW DB_Class();


$courseListSql = "SELECT courses.id, courses.courseName, courses.capacity, courses.province, providers.companyName, courses.archived 
                        FROM courses
                        INNER JOIN providers
                        ON courses.providerId=providers.userId
                        WHERE archived !='Y' AND status='Y'";

$courseLists = $dbconnect->fetch($courseListSql);

echo '
    <h1 class="page-title"><span class="current-page">Curren</span>tly Active Courses</h1>
    <br/>
    <table class="table1">
      <tr>
        <th>Course Name</th>
        <th>Capacity</th>
        <th>Seats Left</th>
        <th>List Of Attendees</th>
      </tr>'; 
foreach($courseLists as $courseList){

    $courseAvailableSeatsSql = "SELECT SUM(numberOfAttendees) FROM user_booking_link WHERE courseid = " . $courseList['id'];
    $courseAvailableSeats = $dbconnect->getone($courseAvailableSeatsSql);
    $availableSeats = $courseList['capacity'] - $courseAvailableSeats;


    $userCourseAttendanceSql= 'SELECT  COUNT(users.id)
                                       FROM user_booking_link
                                       INNER JOIN courses ON user_booking_link.courseId = courses.id
                                       INNER JOIN users ON user_booking_link.userId = users.id
                                       WHERE courseId = ' . $courseList['id'];
    $userCourseAttendance = $dbconnect->getone($userCourseAttendanceSql);

    echo '
      <tr>
        <td><a href="admin_view_courses_details.php?courseId=' . $courseList['id'] . '">' . $courseList['courseName'] . ' - by ' . $courseList['companyName'] . '</a></td>
        <td><strong>' . $courseList['capacity']  . '</strong></td>
        <td>' . $availableSeats . '</td>
        <td><a href="admin_course_attendees.php?courseId=' . $courseList['id'] . '"> ' . $userCourseAttendance .'</a></td>
      </tr>';

}
echo '</table>
<br>
<a href="' . HOSTNAME . 'admin/admin_reports.php"><strong>Back</strong></a>
<br>';
include '../footer.php';
?>

<?php
//turn off deprecicated warnings
error_reporting(E_ALL ^ E_DEPRECATED);
$page_title = 'BpeSA skills Portal - Courses attendees';
require_once '../config.php';
require_once '../header.php';

$userCourseAttendanceSql= 'SELECT
                           users.realName,
                           user_booking_link.courseId,
			                     courses.courseName,
                           courses.courseStartDate,
                           courses.courseEndDate
                           FROM user_booking_link
                           INNER JOIN courses ON user_booking_link.courseId = courses.id
                           INNER JOIN users ON user_booking_link.userId = users.id
                           WHERE courseId = ' . $_GET['courseId'];

$userCourseAttendances = $dbconnect->fetch($userCourseAttendanceSql);
echo '
  <h1 class="page-title"><span class="current-page">Cou</span>rses Attendees</h1>
  <br/>
  <br/>
  <table class="table1">
    <th>Name</th>
    <th>Course Name</th>
    <th>Course Start</th>
    <th>Course End</th>';
if($userCourseAttendances) {

  foreach($userCourseAttendances as $userCourseAttendance){
    echo '
    <tr>
      <td>' . $userCourseAttendance['realName'] . '</td>
      <td>' . $userCourseAttendance['courseName'] . '</td>
      <td>' . $userCourseAttendance['courseStartDate'] . '</td>
      <td>' . $userCourseAttendance['courseEndDate'] . '</td>
    </tr>';
  }

} else {
  echo '<tr><td colspan="4">This user has not attended any courses</td></tr>';
}
  echo '
  </table>';
echo '
  <br />
  <br/>
  <a href="' . HOSTNAME . 'admin/admin_view_courses.php"><strong>Back</strong></a>
  <br />
  <br />';
  
include '../footer.php';
?>

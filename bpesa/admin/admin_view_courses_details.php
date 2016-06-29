<?php
error_reporting(E_ALL ^ E_DEPRECATED);
$page_title = 'BpeSA skills Portal - Courses Details';
require_once '../config.php';
require_once '../header.php';

$courseId = $_GET['courseId'];

$courseDetailSql = "SELECT 
                    courses.courseName,
                    courses.courseDetails, 
                    courses.courseStartDate, 
                    courses.courseEndDate,
                    courses.providerId,
                    providers.companyName
                    FROM courses
                    INNER JOIN providers ON courses.providerId = providers.userId
                    WHERE courses.id = " . $courseId;

$courseDetails = $dbconnect->fetch($courseDetailSql);

echo '
<h1 class="page-title"><span class="current-page">Cou</span>rse Details</h1>
<table class="table1">
<tr>
  <th colspan="2">Course Details</th>
</tr>';

foreach($courseDetails as $courseDetail) {
  echo '
    <tr>
      <td>Course Name</td>
      <td>' . $courseDetail['courseName'] . '</td>
    </tr>
    <tr>
      <td>Course Details</td>
      <td>' . strip_tags($courseDetail['courseDetails']) . '</td>
    </tr>
    <tr>
      <td>Start Date</td>
      <td>' . $courseDetail['courseStartDate'] . '</td>
    </tr>
     <tr>
      <td>End Date</td>
      <td>' . $courseDetail['courseEndDate'] . '</td>
    </tr>';
}
echo '</table>
    <br />
    <a href="admin_view_courses.php"><strong>Back</strong></a>
    <br/>
    <br/>';
include '../footer.php';
?>

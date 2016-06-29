<?php
//turn off deprecicated warnings
error_reporting(E_ALL ^ E_DEPRECATED);
$page_title = 'BpeSA skills Portal - Reports';
require_once '../config.php';
require_once '../header.php';

$currentpage = basename($_SERVER['PHP_SELF']); 
$currentpage = substr($currentpage, 0, -4);

$dbconnect = NEW DB_Class();

$reportPageContentSql = "SELECT pageContent FROM adminpages WHERE pageUrl = '" . $currentpage . "'";
$reportPageContent = $dbconnect->getone($reportPageContentSql);

echo '
	<h1 class="page-title"><span class="current-page">Rep</span>orts</h1>
	<table class="table1">
	<tr>
		<th>Course reports</th>
		<th>Users reports</th>
	</tr>
	<tr>
		<td><a href="' . HOSTNAME . 'reports/reports_course_list.php" data-toggle="tooltip" data-placement="right" title="Currently Active Courses">Full Course List</a></td>
		<td><a href="' . HOSTNAME . 'reports/reports_new_provider_applications.php" data-toggle="tooltip" title="Shows new providers who have registered and not been endorsed or approved">New Provider Applications</a></td>
	<tr>
	<tr>
		<td><a href="' . HOSTNAME . 'reports/reports_user_attendance_list.php" data-toggle="tooltip" title="Shows a list of training providers and their courses with list of users enrolled in that course">User Attendance List</a></td>
		<td><a href="' . HOSTNAME . 'reports/reports_user_list.php" data-toggle="tooltip" class="gray-tooltip" title="Shows a list of users according to your filter">User List</a></td>
	<tr>
	<tr>
		<td><a href="' . HOSTNAME . 'admin/admin_view_courses.php" data-toggle="tooltip" title="Currently Active Courses">Currently Active Courses</a></td>
		<td><a href="' . HOSTNAME . 'reports/reports_vendor_list.php">Facilities provider List</a></td>
	<tr>
	<tr>
		<td></td>
		<td><a href="' . HOSTNAME . 'reports/reports_booked_venues.php" data-toggle="tooltip" title="Shows a list of booked venues">Booked Venues</a></td>
	<tr>
	</table>';

include '../footer.php';
 
?>
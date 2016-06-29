<?php
error_reporting(E_ALL ^ E_DEPRECATED);
$page_title = 'BpeSA skills Portal - Course Details';
require_once '../config.php';
require_once '../header.php';
include '../sessionTest.php';


$currentpage = basename($_SERVER['PHP_SELF']); 
$currentpage = substr($currentpage, 0, -4);

$dbconnect = NEW DB_Class();

$courseDetailsSql = "SELECT courseName, courseDetails, capacity, courseStartDate, courseEndDate, coursePrice FROM courses WHERE id = " . $_GET['course'] . "";
$courseDetails = $dbconnect->fetch($courseDetailsSql);

$courseCompetencyListSql = "SELECT 
                            compentencies.id, 
                            compentencies.competencyName 
                            FROM compentencies 
                            INNER JOIN compentencies_link ON compentencies.id = compentencies_link.competencyId 
                            WHERE compentencies_link.courseid = " . $_GET['course'];
$competencyLists = $dbconnect->fetch($courseCompetencyListSql);

$courseRolesListSql = "SELECT 
                            course_roles.id, 
                            course_roles.roleName 
                            FROM course_roles 
                            INNER JOIN course_roles_link ON course_roles.id = course_roles_link.roleId 
                            WHERE course_roles_link.courseId = " . $_GET['course'];
$rolesLists = $dbconnect->fetch($courseRolesListSql);

echo '
  <h1 class="page-title"><span class="current-page">Cou</span>rses</h1>
    <div class="row">
      <div class="col-lg-6 col-md-6 col-md-12 col-xs-12">';
  foreach($courseDetails as $courseDetail) {
    echo '
    <h2>Course Description</h2>
    <table class="table">
      <form action="' . HOSTNAME . 'functions/operators_add_course.php" method="post">
      <tr>
        <td colspan="2"><label class="text-info">' . $courseDetail['courseName'] . '</label></td>
      </tr>
      <tr>
        <td><label class="text-info">Course Details</label></td>
        <td><textarea name="courseDetails">' . $courseDetail['courseDetails'] . '</textarea></td>
      </tr>
      <tr>
        <td><label class="text-info">Course Capacity</label></td>
        <td><input type="text"  class="form-control" name="courseCapacity" value="' . $courseDetail['capacity']  . '" /></td>
      </tr>
      <tr>
        <td><label class="text-info">Start Date</label></td>
        <td><input type="text"  class="form-control" id="courseStartDate" name="courseStartDate" value="' . $courseDetail['courseStartDate']  . '" /></td>
      </tr>
      <tr>
        <td><label class="text-info">End Date</label></td>
        <td><input type="text"  class="form-control" id="courseEndDate" name="courseEndDate" value="' . $courseDetail['courseEndDate']  . '" /></td>
      </tr>
      <tr>
        <td><label class="text-info">Course Price</label></td>
        <td><input type="text" class="form-control" name="coursePrice" value="' . $courseDetail['coursePrice'] . '" />       
        <input type="hidden" name="courseId" value="' . $_GET['course'] . '" />
        <input type="hidden" name="originUrl" value="' . $currentpage . '"/>
        </td>
      </tr>
       <tr>
        <td>&nbsp;</td>
        <td><input class="btn btn-primary" type="submit" name="updateCourse" value="Update Course" /></td>
      </tr>
    </table>
  </form>
  </div>

  <div class="col-lg-3 col-md-3 col-md-12 col-xs-12">
    <h2>Competency List</h2>
    <br />';
    foreach($competencyLists as $competencyList) {
      echo $competencyList['competencyName'] . '<br />';
    }
	echo '
	</div>

  <div class="col-lg-3 col-md-3 col-md-12 col-xs-12">
	<h2>Roles List</h2>
  <br />';
	if(!empty($rolesLists)) {
	  foreach($rolesLists as $rolesList) {
	    echo $rolesList['roleName'] . '<br />';
	  }  
	}
  }
echo '</div>
</div>';

include '../footer.php';
?>

<?php
require_once '../config.php';
require_once '../header.php';

$dbconnect = NEW DB_Class();

$getCourseDetailsSql = 'SELECT courseDetails FROM courses WHERE id = ' . $_GET['courseId'];
$getCourseDetails = $dbconnect->getone($getCourseDetailsSql);

if($getCourseDetails) {

if(empty($_SESSION['userName'])){ 
	echo '<table width="50%" border="0" class="coursedetailsform">';
}else{
	echo '<table width="50%" border="0">';
}
 echo '
  <tbody>
    <tr>
      <td><h3>Course Details</h3></td>
    </tr>
    <tr>
      <td>'. $getCourseDetails .'</td>
    </tr>
  </tbody>
</table>
<a class = "backbutton" href="' . HOSTNAME . 'users/user_courses.php">Back</a>
<br/>
<br/>' ;
}

include '../footer.php';
<?php
error_reporting(E_ALL ^ E_DEPRECATED);
$page_title = 'BpeSA skills Portal - Courses';
require_once '../config.php';
require_once '../header.php';

$currentpage = basename($_SERVER['PHP_SELF']); 
$currentpage = substr($currentpage, 0, -4);

if(isset($_POST)){
  $filterRegionName = $_POST['formFilter'];

  if($filterRegionName != 'N/A'){
    $where = ' AND vendors.province LIKE "%' . $_POST['formFilter'] . '%"';
  }else{
    $where = '';
  }
}

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

  $onlineusersBookedCoursesSql = "SELECT DISTINCT
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
                                  WHERE courses.status= 'Y'
                                  AND courses.archived !='Y'
                                  AND courses.online ='Y'
                                  AND user_booking_link.userId = " . $_SESSION['userId'] .'';
  $onlineusersBookedCourses = $dbconnect->fetch($onlineusersBookedCoursesSql); 


    if($usersBookedCourses != null || $onlineusersBookedCourses != null) {
      $courseExcludeArray = '';
      foreach($usersBookedCourses as $usersBookedCourse) {
        $courseExcludeArray.=  $usersBookedCourse['courseId'] . ',';
      }
      foreach($onlineusersBookedCourses as $usersBookedCourse) {
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

      $onlinecourseListSql = "SELECT courses.id, 
                               courses.courseName, 
                               courses.province,
                               courses.courseLocation, 
                               courses.courseStartDate, 
                               courses.courseEndDate, 
                               courses.coursePrice,
                               providers.companyName,
                               providers.badge
                               FROM courses
                               INNER JOIN providers ON courses.providerId = providers.userID
                               WHERE status='Y' 
                               AND courses.id NOT IN (" . $courseExcludeArray  . ")
                               AND courses.archived !='Y'
                               AND courses.online ='Y'";
    } else {
    //Get the courses that the user hasnt booked yet
    //Pagination
     $courseListCountSql = "SELECT courses.id, 
                            courses.courseName, 
                            courses.province,
                            courses.courseLocation, 
                            courses.courseStartDate, 
                            courses.courseEndDate, 
                            courses.coursePrice,
                            providers.companyName,
                            providers.badge
                            FROM courses
                            INNER JOIN providers ON courses.providerId = providers.userID
                            INNER JOIN vendor_link ON courses.id = vendor_link.courseId
                            INNER JOIN vendors ON vendor_link.vendorId = vendors.id
                            WHERE status='Y' AND archived !='Y' AND courses.venueBooked ='Y'" . $where ;
        $courseListCount = $dbconnect->fetch($courseListCountSql);
//pagination script
$base_url = HOSTNAME;
$per_page = 5;                           //number of results to shown per page 
$num_links = 8;                           // how many links you want to show
$total_rows = count($courseListCount); 
$cur_page = 1;                           // set default current page to 1

if(isset($_GET['page'])){
	$cur_page = $_GET['page'];
	$cur_page = ($cur_page < 1)? 1 : $cur_page;            //if page no. in url is less then 1 or -ve
}

$offset = ($cur_page-1)*$per_page;                //setting offset

$pages = ceil($total_rows/$per_page);              // no of page to be created
$start = (($cur_page - $num_links) > 0) ? ($cur_page - ($num_links - 1)) : 1;
$end   = (($cur_page + $num_links) < $pages) ? ($cur_page + $num_links) : $pages;    
//end pagination    

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
                           WHERE status='Y' AND archived !='Y' AND courses.venueBooked ='Y' " . $where . " LIMIT ". $per_page ." OFFSET " . $offset .""; 
$onlinecourseListSql = "SELECT courses.id, 
                           courses.courseName,
                           courses.province, 
                           courses.courseLocation, 
                           courses.courseStartDate, 
                           courses.courseEndDate, 
                           courses.coursePrice,
                           providers.companyName,
                           providers.badge
                           FROM courses
                           INNER JOIN providers ON courses.providerId = providers.userID
                           WHERE status='Y' AND archived !='Y' AND courses.online ='Y'";       
    }
} else {
  //get the lsit of courses for non logged in users
  $courseListSql = "SELECT courses.id, 
                           courses.courseName,
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
                           WHERE courses.status='Y' AND courses.archived !='Y' AND courses.venueBooked ='Y' " . $where ."
                           ORDER BY courses.courseName";

  $onlinecourseListSql = "SELECT courses.id, 
                                   courses.courseName,
                                   courses.courseLocation,  
                                   courses.courseStartDate, 
                                   courses.courseEndDate, 
                                   courses.coursePrice,
                                   providers.companyName,
                                   providers.badge
                                   FROM courses
                                   INNER JOIN providers ON courses.providerId = providers.userID
                                   WHERE courses.status='Y' AND courses.archived !='Y' AND courses.online ='Y'
                                   ORDER BY courses.courseName";                         
}

$courseLists = $dbconnect->fetch($courseListSql);
$onlineCourses = $dbconnect->fetch($onlinecourseListSql);

$userCourseContentSql = "SELECT pageContent FROM userpages";
$userCourseContent = $dbconnect->getone($userCourseContentSql);

echo '<h1 class="page-title"><span class="current-page">Cou</span>rses</h1>

<table style="margin:auto;width:95%;" border="0">
  <tbody>
    <tr>
      <th scope="col"><p class="text-info">You can also access free courses on:</p></th>
    </tr>
    <tr>
      <td><a href="http://alison.com/courses/How-to-Plan-Your-Career-Path">How to Plan Your Career Path</a></td>
    </tr>
    <tr>
      <td><a href="http://alison.com/courses/MSDL-M1">Microsoft Digital Literacy Computer Basics</a></td>
    </tr>
    <tr>
      <td><a href="https://alison.com/courses/Customer-Support-Training/content/scorm/3551/introduction-to-customer-service">Introduction to Customer Service</a></td>
    </tr>
  </tbody>
</table>
      ';

include '../functions/pagination_navigation.php'; 

$filterregionNamesSql = "SELECT id, regionNames FROM regions";
$filterregionNamesLists = $dbconnect->fetch($filterregionNamesSql);

echo '
<br/>
<table class="table1">
  <tr>
   <th colspan="7">
		<h1><span class="current-heading">Ava</span>ilable courses </h1>
   </th>
    <th colspan="1">
      <form action="user_courses.php" method="post">
      <input type="hidden" name="startDate" value="' . $_REQUEST['startDate'] . '">
      <input type="hidden" name="endDate" value="' . $_REQUEST['endDate'] . '">
        <span id="hideSelectOption">
        <div id="selectDiv" style="float:left;">
          <select name="formFilter">
          <option value="N/A" selected="selected"> Select All </option> ';
          foreach($filterregionNamesLists as $filterregionNamesList){
            echo '<option value="' . $filterregionNamesList['regionNames'] . '">' . $filterregionNamesList['regionNames'] . '</option>';
          }
           
    echo '
        </select>
      </div>
      <div style="clear:both;"></div>
      </span>
      <br >
      <input type="submit" class="btn btn-primary" value="Filter Records">
      </form>
    </th>
  </tr>
<tr>
  <th>Course Name</th>
  <th>Provider</th>
  <th>Start Date</th>
  <th>End Date</th>
  <th>Course Price</th>
  <th>Course Location</th>
  ';
  if($_SESSION['userName'] !='') { 
    echo '<th>Place a Booking</th>';
  } 
?>
<th>Online</th>
</tr>

<?php
  if(!empty($courseLists)) {

    foreach($courseLists as $courseList) {

     if($courseList['badge'] == "Y") {
          $courseBadge = '<span class="badge">' . $courseList['companyName'] . '</span> ';
          $height = ' style="height:60px;"';
      }else{
          $courseBadge = '' . $courseList['companyName'] . '';
           $height = false;
      } 

      echo '
      <tr ' . $height . '>';
        if($_SESSION['userName'] =='') {
          echo '<td>
                  <a class="normal_link" style="text-decoration:underline;" href="' . HOSTNAME .  'users/user_book_course.php?userId=0&courseId=' . $courseList['id'] . '&booked=Y">
                   ' . ucwords($courseList['courseName']) . '
                  </a>
                </td>';
        } else {
          echo '<td>' . ucwords($courseList['courseName']) . '</td>';
        }

   
        echo '
        <td>' . $courseBadge .'</td>
        <td>' . $courseList['courseStartDate'] . '</td>
        <td>' . $courseList['courseEndDate'] . '</td>
        <td>R ' . number_format($courseList['coursePrice'],2) . '</td>
        <td>';

        if($courseList['province'] == 'N/A'){
          echo $courseList['vendorLocation'] . '</td>';
        }else{
          echo $courseList['province'] . ' - '. $courseList['vendorLocation'] . '</td>';
        }

        if($_SESSION['userName'] !='') {
          echo '<td>
              <a class="normal_link" style="text-decoration:underline;" href="' . HOSTNAME .  'users/user_book_course.php?userId=' . $_SESSION['userId'] . '&courseId=' . $courseList['id'] . '">
              View Details/Book a Course
            </a>
        </td>
        ';
      } 
      echo '<td>No</td>
      </tr>';
   }

   //online course display
    if(!empty($onlineCourses)) {
      
      foreach($onlineCourses as $onlineCourseList) {
        if($onlineCourseList['badge'] == "Y") {
          $courseBadge = '<span class="badge">' . $onlineCourseList['companyName'] . '</span> ';
          $height = ' style="height:60px;"';
      }else{
          $courseBadge = '' . $onlineCourseList['companyName'] . '';
           $height = false;
      } 

      echo '
      <tr ' . $height . '>';
        if($_SESSION['userName'] =='') {
          echo '<td>
                  <a class="normal_link" style="text-decoration:underline;" href="' . HOSTNAME .  'users/user_book_course.php?userId=0&courseId=' . $onlineCourseList['id'] . '&booked=Y&online=Y">
                   ' . ucwords($onlineCourseList['courseName']) . '
                  </a>
                </td>';
        } else {
          echo '<td>' . ucwords($onlineCourseList['courseName']) . '</td>';
        }

   
        echo '
        <td>' . $courseBadge .'</td>
        <td>' . $onlineCourseList['courseStartDate'] . '</td>
        <td>' . $onlineCourseList['courseEndDate'] . '</td>
        <td>R ' . number_format($courseList['coursePrice'] , 2) . '</td>
        <td> </td>';

        if($_SESSION['userName'] !='') {
          echo '<td>
              <a class="normal_link" style="text-decoration:underline;" href="' . HOSTNAME .  'users/user_book_course.php?userId=' . $_SESSION['userId'] . '&courseId=' . $onlineCourseList['id'] . '&online=Y">
              View Details/Book a Course
            </a>
        </td>
        ';
      } 
    echo '<td>Yes</td>
      </tr>';
      }
    }

  } else {
    echo '
      <tr>
        <td colspan="7">there are no available courses</td>
      </tr>';
  }
?>

</table>
<br/>

<?php  
if($_SESSION['userName'] !='') {
  echo '
    <table class="table1">
      <th>Booked Courses</th>';
      if(!empty($usersBookedCourses) || !empty($onlineusersBookedCourses)) {
      foreach($usersBookedCourses as $usersBookedCourse) {
        echo '
          <tr>
            <td>
              <a href="' . HOSTNAME . 'users/user_book_course.php?courseId=' . $usersBookedCourse['courseId'] . '&userId=' .  $_SESSION['userId'] . '&booked=Y">' .$usersBookedCourse['courseName'] . '</a><br />
            </td>
         </tr>';
      }
      foreach($onlineusersBookedCourses as $usersBookedCourse) {
        echo '
          <tr>
            <td>
              <a href="' . HOSTNAME . 'users/user_book_course.php?courseId=' . $usersBookedCourse['courseId'] . '&userId=' .  $_SESSION['userId'] . '&booked=Y&online=Y">' .$usersBookedCourse['courseName'] . '</a><br />
            </td>
         </tr>';
      }
     }else{
      echo '
          <tr>
            <td>
              There are no courses booked
            </td>
         </tr>';
     }
  echo '
    </table>';
}
include '../footer.php'; 
?>
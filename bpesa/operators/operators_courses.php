<?php
//turn off deprecicated warnings
error_reporting(E_ALL ^ E_DEPRECATED);
$page_title = 'BpeSA skills Portal - Courses';
require_once '../config.php';
require_once '../header.php';
include '../sessionTest.php';

$currentpage = basename($_SERVER['PHP_SELF']); 
$currentpage = substr($currentpage, 0, -4);

$dbconnect = NEW DB_Class();

$regionNamesSql = "SELECT id, regionNames FROM regions";
$regionNamesOptions = $dbconnect->fetch($regionNamesSql);

//Pagination
$courseListcountSql = "SELECT id, courseName, status, courseStartDate, courseEndDate, courseLocation, venueBooked 
                       FROM courses WHERE providerId = " . $_SESSION['userId'] . " AND archived !='Y'";
$courseListcount = $dbconnect->fetch($courseListcountSql);
//pagination script

 $base_url = HOSTNAME;
 $per_page = 5;//number of results to shown per page 
 $num_links = 8;// how many links you want to show
 $total_rows = count($courseListcount); 
 $cur_page = 1;// set default current page to 1
  
  if(isset($_GET['page']))
    {
      $cur_page = $_GET['page'];
      $cur_page = ($cur_page < 1)? 1 : $cur_page;//if page no. in url is less then 1 or -ve
    }
    
$offset = ($cur_page-1)*$per_page;//setting offset
   
$pages = ceil($total_rows/$per_page);// no of page to be created
$start = (($cur_page - $num_links) > 0) ? ($cur_page - ($num_links - 1)) : 1;
$end   = (($cur_page + $num_links) < $pages) ? ($cur_page + $num_links) : $pages;
//End pagination

$courseListSql = "SELECT id, courseName, status, courseStartDate, courseEndDate, courseLocation, venueBooked 
                  FROM courses WHERE providerId = " . $_SESSION['userId'] . " AND archived !='Y'LIMIT ".$per_page." OFFSET " .$offset ."";

$courseLists = $dbconnect->fetch($courseListSql);

$archivedCourseListsSql = "SELECT id, courseName, status, courseStartDate, courseEndDate, courseLocation, venueBooked FROM courses WHERE providerId = " . $_SESSION['userId'] . " AND archived ='Y'";
$archivedCourseLists = $dbconnect->fetch($archivedCourseListsSql);

$competencyListSql = "SELECT competencyName FROM compentencies";
$competencyLists = $dbconnect->fetch($competencyListSql);

$providerCourseContentSql = "SELECT pageContent FROM providerpages WHERE pageUrl = '" . $currentpage . "'";
$providerCourseContent = $dbconnect->getone($providerCourseContentSql);

echo '<h1 class="page-title"><span class="current-page">Cou</span>rses</h1>';
//pagination links
include '../functions/pagination_navigation.php';

?>

  <table class="table1">
    <th>Course Name</th>
    <th>Roles</th>
    <th>Competencies</th>
    <th>Active</th>
    <th>Accreditation</th>
    <th>Course Dates</th>
    <th>Attendees</th>
    <th>Venues</th>
  <?php
  if(!empty($courseLists)){
  foreach($courseLists as $courseList) {
    echo '
      <tr>
        <td><a href="operators_course_details.php?course=' . $courseList['id'] . '&originUrl=' . $currentpage . '">' . $courseList['courseName'] . '</a></td>
        <td><a href="operators_course_add_role.php?courseid=' . $courseList['id'] . '&originUrl=' . $currentpage . '">add/edit roles</a></td>
        <td><a href="operators_course_add_competency.php?courseid=' . $courseList['id'] . '&originUrl=' . $currentpage . '">Add/Edit</a></td>';
        if($courseList['venueBooked'] != 'Y') { 
          echo '
          <td>Venue Needed</td>';
        } else {
          if($courseList['status'] == 'Y') {
 
            echo '
            <td>
              <a href="' . HOSTNAME . 'functions/provider_add_course.php?orginUrl=' . $currentpage . '&status=Y&courseid=' . $courseList['id'] . '"><img src="' . HOSTNAME . 'images/tick.jpg" width=15px/></a>
            </td>';
          } else {
            echo '
            <td>
              <a href="' . HOSTNAME . 'functions/provider_add_course.php?orginUrl=' . $currentpage . '&status=N&courseid=' . $courseList['id'] . '"><img src="' . HOSTNAME . 'images/cross.jpg" width=15px/></a>
            </td>';
          }
        }
    
    echo '<td>Accredition Status</td>
           <td>' .$courseList['courseStartDate'] . ' - ' . $courseList['courseEndDate'] . '</td>
           <td><a href="' . HOSTNAME . 'operators/operators_attendees_list.php?courseId=' .  $courseList['id'] . '&orginUrl=' . $currentpage . '">List of Attendees</a></td>
         <td>';
    if($courseList['venueBooked'] == 'Y') {
      $bookedVenueSql = "SELECT vendors.vendorName
                         FROM vendors
                         INNER JOIN vendor_link 
                         ON vendors.id = vendor_link.vendorId
                         WHERE courseId = " . $courseList['id'];
      $bookedVenue = $dbconnect->getone($bookedVenueSql);
      echo $bookedVenue . 
            '</td>';
    } else {     
      echo '
        <a href="' . HOSTNAME . 'operators/operators_book_venue.php?courseId=' .  $courseList['id'] . '&orginUrl=' . $currentpage . '&startDate=' . $courseList['courseStartDate'] . '&endDate=' . $courseList['courseEndDate'] . '">
          Book a Venue
        </a>
       </td>';
    }
    echo '</tr>';
  }
  }else{
	  echo '<tr><td colspan="8">You currently don\'t have courses</td></tr>';
  }
  ?>
  </table>
  <!--add new course-->
  <br />
  <br />
  <!--view Archived courses-->
  <div id="showFormButton"><h2><span class="selectors">View Past Courses</span></h2></div>
  <div id="showEmailForm" style="display:none;">
  <?php
    if($archivedCourseLists) {
      echo '
      <table class="table1">
        <th>Course Name</th>
        <th>Course Dates</th>
        <th>Venues</th>';
       foreach($archivedCourseLists as $archivedCourseList) {
         echo'
           <tr>
             <td>' . $archivedCourseList['courseName'] . '</td>
             <td>' . $archivedCourseList['courseStartDate'] . ' - ' . $archivedCourseList['courseEndDate'] . '</td>
             <td>' . $archivedCourseList['courseLocation'] . '</td>
          </tr>';
      }
      echo '</table>';
    } else {
      echo 'You have no archived courses';
    }
  ?>
  </div>
  <br />
  <!--add a new course-->
  <div id="showFormButtonForm">
     <h2><span class="selectors">Add A New Course</span></h2>
  </div>
  <div id="showEmailForm2" style="display:none;">
    <div class="col-lg-6 col-md-6 col-md-12 col-xs-12"> 
  <form action="<?php echo HOSTNAME . 'functions/operators_add_course.php'; ?>" method="post" name="AddCourse" onsubmit="return validateForm2()"> 
    <table class="table">
      <tr>
        <td><label class="text-info">Course Name</label>      
      <span data-toggle="tooltip" data-placement="top" title="Course full name">
        <img src="../images/tooltip.png" class="img-fluid pull-right" alt="Responsive image">
      </span>
    </td>  
        <td>
      <input type="hidden" name="originUrl" value="<?php echo $currentpage ?>">
      <input type="hidden" name="id" value="<?php echo $_SESSION['userId'] ?>">
      <input type="text" class="form-control " name="courseName">
    </td>
      </tr>
      <tr>
        <td><label class="text-info">Description</label>
    <span data-toggle="tooltip" data-placement="top" title="A brief description of the course">
      <img src="../images/tooltip.png" class="img-fluid pull-right" alt="Responsive image">
    </span>
    </td>  
        <td><textarea id="courseDescription" name="courseDescription"></textarea></td>    
      </tr>
      <tr>
        <td><label class="text-info">Start Date</label>
    <span data-toggle="tooltip" data-placement="top" title="The start date of the course">
      <img src="../images/tooltip.png" class="img-fluid pull-right" alt="Responsive image">
    </span>
    </td>
        <td><input type="text" class="form-control" id="courseStartDate" name="courseStartDate"></td>
      </tr>
      <tr>
        <td><label class="text-info">End Date</label>
    <span data-toggle="tooltip" data-placement="top" title="The end date of the course">
      <img src="../images/tooltip.png" class="img-fluid pull-right" alt="Responsive image">
    </span>
    </td>
        <td><input type="text" class="form-control" id="courseEndDate" name="courseEndDate"></td>
      </tr>
      <tr>
        <td><label class="text-info">Course Capacity</label>
    <span data-toggle="tooltip" data-placement="top" title="Number of people for this course">
      <img src="../images/tooltip.png" class="img-fluid pull-right" alt="Responsive image">
    </span>
    </td>  
        <td><input type="text" class="form-control" name="courseCapacity"></td>    
      </tr>
      <tr>
        <td><label class="text-info">Price</label>
    <span data-toggle="tooltip" data-placement="top" title="Course price per person">
      <img src="../images/tooltip.png" class="img-fluid pull-right" alt="Responsive image">
    </span>
    </td>  
        <td><input type="text" class="form-control" name="coursePrice"></td>    
      </tr>
    <tr>
        <td><label class="text-info">Course online</label>
    <span data-toggle="tooltip" data-placement="top" title="Indicates whether the course is online or not">
      <img src="../images/tooltip.png" class="img-fluid pull-right" alt="Responsive image">
    </span>
    </td> 
         <td>
          <input type="radio" class="online" name="online" value="Y"> Yes
          <input type="radio" class="online" name="online" value="N"> No
        </td>    
      </tr>
      <tr id="location">
        <td><label class="text-info">Location</label>
    <span data-toggle="tooltip" data-placement="top" title="Course location area, Johannesburg etc.">
      <img src="../images/tooltip.png" class="img-fluid pull-right" alt="Responsive image">
    </span>
    </td> 
        <td><input type="text" class="form-control" name="courseLocation"></td>    
      </tr>
      <tr id="province">
        <td><label class="text-info">Province</label></td> 
        <td>
          <?php
          echo '<div style="float:left;" id="selectDiv">
                <select name="province">
                  <option value="N/A" selected>Select One</option>';
                foreach($regionNamesOptions as $regionNamesOption) {
                  echo '
                  <option value="' . $regionNamesOption['regionNames'] . '">' . $regionNamesOption['regionNames'] . '</option>';  
                }
          echo '</select>
                </div>';        
          ?>
        </td>    
      </tr>
      <tr>
        <td>&nbsp;</td>  
        <td><input class="btn btn-primary" type="submit" name="NewCourse" value="Save Course"></td>    
      </tr>
      </form>
    </table>
    </div>
    </div>
<?php include '../footer.php'; ?>
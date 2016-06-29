<?php
error_reporting(E_ALL ^ E_DEPRECATED);
$page_title = 'BpeSA skills Portal - Book course';
require_once '../config.php';
require_once '../header.php';

$currentpage = basename($_SERVER['PHP_SELF']); 
$currentpage = substr($currentpage, 0, -4);

if(!empty($_GET['courseId'])) {

if(!empty($_GET['online'])) {
 //online course 
 $courseDetailsSql = "SELECT 
                        courses.id, 
                        courses.courseName, 
                        courses.courseDetails, 
                        courses.courseStartDate, 
                        courses.courseEndDate,
                        courses.providerId,
                        courses.capacity,
                        courses.coursePrice,
                        provider_payment_gateway.merchantId,
                        provider_payment_gateway.merchantKey
                        FROM courses
                        INNER JOIN provider_payment_gateway ON courses.providerId = provider_payment_gateway.providerId
                        WHERE courses.id = " . $_GET['courseId'] ." 
                        AND courses.status = 'Y' LIMIT 1";
} else {
$courseDetailsSql = "SELECT 
                        courses.id, 
                        courses.courseName, 
                        courses.courseDetails, 
                        courses.courseStartDate, 
                        courses.courseEndDate,
                        courses.providerId,
                        courses.capacity,
                        courses.coursePrice,
                        vendors.vendorLocation, 
                        vendors.province, 
                        vendors.vendorName,
                        vendors.userId,
                        provider_payment_gateway.merchantId,
                        provider_payment_gateway.merchantKey
                        FROM courses
                        INNER JOIN vendor_link ON courses.id = vendor_link.courseId
                        INNER JOIN vendors ON vendor_link.vendorId = vendors.id
                        INNER JOIN provider_payment_gateway ON courses.providerId = provider_payment_gateway.providerId
                        WHERE courses.id = " . $_GET['courseId'] ." 
                        AND courses.status = 'Y' LIMIT 1";
  }

  $courseDetails = $dbconnect->fetch($courseDetailsSql);
  
  $competencyListsSql = "SELECT compentencies.competencyName
                         FROM compentencies
                         INNER JOIN compentencies_link ON compentencies.id = compentencies_link.competencyId
                         AND compentencies_link.courseId = " .$_GET['courseId'] . "
                         GROUP BY competencyName";
  
  $roleListsSql = "SELECT course_roles.roleName
                   FROM course_roles
                   INNER JOIN course_roles_link ON course_roles.id = course_roles_link.roleId
                   AND course_roles_link.courseId = " . $_GET['courseId'] . "
                   GROUP BY roleName";
  
  $roleLists = $dbconnect->fetch($roleListsSql);
    
  $competencyLists = $dbconnect->fetch($competencyListsSql);
  
  $courseAvailableSeatsSql = "SELECT SUM(numberOfAttendees) FROM user_booking_link WHERE courseid = " . $_GET['courseId'];
  $courseAvailableSeats = $dbconnect->getone($courseAvailableSeatsSql);

  foreach($courseDetails as $courseDetail) {
      $availableSeats = $courseDetail['capacity'] - $courseAvailableSeats;


      //strip tags to avoid breaking any html
      $courseDescription = strip_tags($courseDetail['courseDetails']);

      if (strlen($courseDescription) > 500) {
          //truncate string
          $stringCut = substr($courseDescription, 0, 500);
          // make sure it ends in a word so assassinate doesn't become ass...
          $courseDescription = substr($stringCut, 0, strrpos($stringCut, ' ')) .'  <a href="' . HOSTNAME . 'users/user_details_popup.php?courseId=' . $courseDetail['id'] . '" target="_blank">...Read More</a>'; 
      }

      echo'
    <h1 class="page-title"><span class="current-page">Edi</span>t profile</h1>
    <br/>
    <table class="table1">
      <th colspan="2">Course Details</th>
      <tr>
        <td>Course Title</td>
        <td><h3>' . $courseDetail['courseName'] . '</h3></td>
      </tr>
      <tr>
        <td>Course Details</td>
        <td>
          <div style="max-height:150px; overflow:hidden;">' . $courseDescription . '</div>
        </td>
      </tr>';

    if(empty($_GET['online'])) {
    echo 
      '<tr>
        <td>Course Location</td>
        <td>';

      if($courseDetail['province']=='N/A'){
        echo $courseDetail['vendorLocation'] . '</td>';
      }else{
        echo $courseDetail['province'] . ' - '. $courseDetail['vendorLocation'] . '</td>';
      }

    echo '
      </tr>
      <tr>
        <td>Course Venue</td>
        <td>' . $courseDetail['vendorName'] . '</td>
      </tr>';
    }
    echo
      '<tr>
        <td>Start Date</td>
        <td>' . $courseDetail['courseStartDate']  . '</td>
      </tr>
      <tr>
        <td>End Date</td>
        <td>' . $courseDetail['courseEndDate'] . '</td>
      </tr>
      <tr>
        <td>Course Capacity</td>
        <td>' . $courseDetail['capacity'] . '</td>
      </tr>
      <tr>
        <td>Available Seats</td>
        <td>' . $availableSeats . '</td>
      </tr>
      </table>';
      
      //Add the Competency List associated with this course
      echo'
      <br />
      <table class="table1">
        <th colspan="2">Course Competencies</th>';
        foreach($competencyLists as $competencyList){
          echo '
          <tr>
            <td>' . $competencyList['competencyName'] . '</td>
          </tr>';
        }  
      echo '
      </table>
      <br />
      <br />
       <table class="table1">
        <th colspan="2">Roles</th>';
        foreach($roleLists as $roleList){
          echo '
          <tr>
            <td>' . $roleList['roleName'] . '</td>
          </tr>';
        }  
      echo '
      </table>
      <br />';
      if (!empty($_SESSION['userName'])) {
        if($_GET['booked'] != 'Y') {
        echo ' 
          <form action="' . HOSTNAME . 'users/user_booking_payment.php" method="post" name="formBooking" onsubmit="return validateFormBooking()">
            <p> Number of seats to book : 
            <input type="text" style="width:12em;" class="form-control" name="numberOfbookings">
            <input type="hidden" name="merchantId" value="' . $courseDetail['merchantId'] . '" >
            <input type="hidden" name="merchantKey" value="' . $courseDetail['merchantKey'] . '" >
            <input type="hidden" name="userId" value="' . $_SESSION['userId'] . '" >
            <input type="hidden" name="courseId" value="' . $courseDetail['id'] . '" >
            <input type="hidden" name="coursePrice" value="' . $courseDetail['coursePrice'] . '" >
            <input type="hidden" name="currentPage" value="' . $currentpage . '" > 
			</p>			
            <input type="submit" class="btn btn-primary" value="BOOK NOW" >
        </form>';
      }
        echo '
        <div id="showFormButton">
			<h2><span class="selectors">Contact The Provider</span></h2>
		</div>
    <br />
        <div id="showEmailForm" style="display:none;">
          <form name="contactProviderForm" action="' . HOSTNAME . 'send_new_message.php" method="post" onsubmit="return validateContactProviderForm()">
            <textarea name="message"></textarea>
            <input type="hidden" name="subject" value="' . $courseDetail['courseName'] . '">
            <input type="hidden" name="senderId" value="' . $_SESSION['userId'] . '">
            <input type="hidden" name="recipientId" value="' . $courseDetail['providerId'] . '">
            <br />
            <input type="submit" class="btn btn-primary" value="Send">
          </form>
          </div>';
 
     } else {
       echo 'Please ensure that you are logged in.';
     }
  }
}
echo "<br />";
include '../footer.php';
?>

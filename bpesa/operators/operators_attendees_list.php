<?php
error_reporting(E_ALL ^ E_DEPRECATED);
require_once '../config.php';
require_once '../header.php';
include '../sessionTest.php';

$dbconnect = NEW DB_Class();
$listofAttendeesSql = "SELECT users.id, 
                              users.userName,
                              users.realName,
                              users.userEmail,
                              courses.courseName
                       FROM users
                       INNER JOIN user_booking_link
                       ON users.id = user_booking_link.userId
                       INNER JOIN courses
                       ON user_booking_link.courseId = courses.id
                       WHERE user_booking_link.courseId = " . $_GET['courseId'];
$listofAttendees = $dbconnect->fetch($listofAttendeesSql);

echo '
  <table class="table1">
    <th>Course</th>
    <th>Attendee</th>
    <th>Email</th>';
    if(!empty($listofAttendees)) {
      foreach($listofAttendees as $listofAttendee) {
        echo '
        <tr>
          <td>' . $listofAttendee['courseName'] . '</td>
          <td>' . $listofAttendee['realName'] . '</td>
          <td><a href="' . HOSTNAME . 'provider_to_user_message.php?senderId=' . $_SESSION['userId'] . '&recipient=' . $listofAttendee['id'] . '">' . $listofAttendee['userEmail'] . '</a></td>
        </tr>';
      }
    } else {
      echo '
      <tr>
          <td colspan="3">There are currently no bookings for this course</td>
      </tr>';
    }
echo '</table>';
include '../footer.php';
?>

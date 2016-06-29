<?php
//turn off deprecicated warnings
error_reporting(E_ALL ^ E_DEPRECATED);
require_once '../config.php';

$dbconnect = NEW DB_Class();

$saveBookingSql = "INSERT INTO vendor_link (vendorId, courseId, courseStartDate, courseEndDate)
                   VALUES (" . $_GET['vendorId'] . ", " . $_GET['courseId'] . ", '" . $_GET['startDate'] . "', '" . $_GET['endDate'] . "')";

$courseBookedStatusSql = "UPDATE courses SET venueBooked='Y' WHERE id = " . $_GET['courseId'] . "";
$courseBookedStatus = $dbconnect->query($courseBookedStatusSql);

$venueBookedSql = "UPDATE vendors SET venueBooked='Y' WHERE id = " . $_GET['vendorId'];
$venueBooked = $dbconnect->query($venueBookedSql);
$saveBooking = $dbconnect->query($saveBookingSql);

$getVendorEmailSql = "SELECT vendorEmail FROM vendors WHERE id = " . $_GET['vendorId'];
$getVendorEmail = $dbconnect->getone($getVendorEmailSql);

$getProviderNameSql = "SELECT CompanyName FROM providers WHERE userID = " . $_SESSION['userId'];
$getProviderName = $dbconnect->getone($getProviderNameSql);

//Send email to venue hire to make sure of booking    
$to = $getVendorEmail;
$subject = $getProviderName . ' would like to book your Venue.';
$message = "
<html>
<head>
  <title>Venue Booking</title>
</head>
<body>
  <h3>New Booking from " . $getProviderName  . "</h3>
  <p>Start Date: " . $_GET['startDate'] . "</p>
  <p>Start Date: " . $_GET['endDate'] . "</p>
</body>
</html>";

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";

// More headers
$headers .= 'From: BPeSA Skills Portal';

mail($to,$subject,$message,$headers);
header( 'Location: '. HOSTNAME . 'operators/operators_thank_you.php');

if($saveBooking) {
  header( 'Location: '. HOSTNAME . 'operators/operators_courses.php');
}
?>

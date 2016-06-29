<?php
error_reporting(E_ALL ^ E_DEPRECATED);
$page_title = 'BpeSA skills Portal - Booking payment';
require_once '../config.php';
require_once '../header.php';
include '../sessionTest.php';

$currentpage = basename($_SERVER['PHP_SELF']); 
$currentpage = substr($currentpage, 0, -4);


$getCapcitySql = 'SELECT capacity FROM courses WHERE id = ' . $_POST['courseId'];
$courseCapacity = $dbconnect->getone($getCapcitySql);

$courseAvailableSeatsSql = "SELECT SUM(numberOfAttendees) FROM user_booking_link WHERE courseId = " . $_POST['courseId'];
$courseAvailableSeats = $dbconnect->getone($courseAvailableSeatsSql);

$availableSeats = $courseCapacity - $courseAvailableSeats;
$numberOfbookings = $_POST['numberOfbookings'];

$getCourseNameSql = 'SELECT courseName FROM courses WHERE id = ' . $_POST['courseId'];
$getCourseName = $dbconnect->getone($getCourseNameSql);

if($numberOfbookings < $availableSeats) {

$getUserDetailsSql = 'SELECT userName,realName, userEmail FROM users WHERE id=' . $_POST['userId'];
$getUserDetails = $dbconnect->fetch($getUserDetailsSql);



foreach($getUserDetails as $getUserDetail) {
  $firstName = $getUserDetail['userName'];
  $LastName = $getUserDetail['realName'];
  $emailAddress = $getUserDetail['userEmail'];
}

$coursePrice = $_POST['numberOfbookings'] * $_POST['coursePrice'];
echo '<h1 class="page-title"><span class="current-page">Boo</span>king Payment</h1>';
echo 'You have chosen to book <strong>' . $_POST['numberOfbookings'] . '</strong> places for the course: <strong>' . $getCourseName . '</strong><br /><br />
      Please choose whether you want to pay online now, or just make the booking and pay using another method. Please note that each provider may have different terms and conditions.<br /><br />';

$randomBpeSABookingCode = rand(1, 1500);
if($_POST['merchantId'] != 'N/A') {
  
  echo '
  <form action="https://www.payfast.co.za/eng/process" method="post" name="frmPay" id="frmPay">
  <!--<form action="https://sandbox.payfast.co.za/eng/process" method="post" name="frmPay" id="frmPay">-->
    <!--receiver details -->
    
    <input type="hidden" name="merchant_id" value="' . $_POST['merchantId'] . '">
    <input type="hidden" name="merchant_key" value="' . $_POST['merchantKey'] . '">

    <input type="hidden" name="return_url" value="http://www.bpesaskillsportal.co.za/users/user_payment_success.php">
    <input type="hidden" name="cancel_url" value="http://www.bpesaskillsportal.co.za/users/payment_cancelled.php">
    <input type="hidden" name="notify_url" value="http://www.bpesaskillsportal.co.za/users/payment_notify.php">
	
	<!--payer details -->
    <input type="hidden" name="name_first" value="' . $firstName . '">
    <input type="hidden" name="name_last" value="' . $lastName . '">
    <input type="hidden" name="email_address" value="' . $emailAddress . '">
	
	<!--Transaction details -->
	  <input type="hidden" name="m_payment_id" value="' . $_POST['userId'] . '_' . $randomBpeSABookingCode . '">
    <input type="hidden" name="amount" value="' . $coursePrice . '">
    <input type="hidden" name="item_name" value="' . $getCourseName . '">
    <input type="hidden" name="item_description" value="Proudly Enabled By BPeSA Western Cape">

    <input type="hidden" name="custom_int1" value="' . $_POST['userId'] . '" />
    <input type="hidden" name="custom_int2" value="' . $_POST['id'] . '" />
    <input type="hidden" name="custom_int3" value="' . $_POST['numberOfbookings'] . '" />
		
    <input type="submit" class="btn btn-primary" name="payNow" value="Pay Online">
  </form>
  <div class="hover" style="left:200px; top:-24px;"><img src="' . HOSTNAME . 'images/icon.png">
    <div class="tooltip">You will be able to pay for the course online using a credit card though an external secure payment vendor.</div>
  </div>
  <br />';
} 
 echo '<form action="' . HOSTNAME . 'functions/user_booking_save.php" method="post">
    <input type="hidden" name="numberOfbookings" value="' . $_POST['numberOfbookings'] . '" />
    <input type="hidden" name="userId" value="' . $_POST['userId'] . '" />
    <input type="hidden" name="courseId" value="' . $_POST['courseId'] . '" />
    <input type="submit" class="btn btn-primary" name="bookOnly" value="Book Only">
  </form>';

 }else {

  echo '
      You have chosen to book <strong>' . $_POST['numberOfbookings'] . '</strong> places for the course: <strong>' . $getCourseName . '</strong><br /><br />
      However we only have <strong> ' . $availableSeats . '</strong> seats available. 
      <br />
      <br />
      <a href="' . HOSTNAME . 'users/user_book_course.php?userId=' . $_POST['userId'] . '&courseId=' .  $_POST['courseId'] . '"><strong>Back</strong></a>
      <br/>
      <br/>';
 } 

include '../footer.php';
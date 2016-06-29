<?php
//turn off deprecicated warnings
error_reporting(E_ALL ^ E_DEPRECATED);
$page_title = 'BpeSA skills Portal - Course Providers and Attendance List';
require_once '../config.php';
require_once '../header.php';

$userCourseAttendanceSql= 'SELECT
                           users.realName,
                           user_booking_link.courseId,
						   courses.courseName,
                           courses.courseStartDate,
                           courses.courseEndDate
                           FROM user_booking_link
                           INNER JOIN courses ON user_booking_link.courseId = courses.id
                           INNER JOIN users ON user_booking_link.userId = users.id
                           WHERE userId = ' . $_GET['userId'];

$userCourseAttendances = $dbconnect->fetch($userCourseAttendanceSql);


  echo '
  <h1 class="page-title"><span class="current-page">Cou</span>rse Providers and Attendance List</h1>
  <table class="table1">
    <th>Course Provider Name</th>
    <th>Course Name</th>
    <th>Course Start</th>
    <th>Course End</th>';
if($userCourseAttendances) {
  foreach($userCourseAttendances as $userCourseAttendance){
    echo '
    <tr>
      <td>' . $userCourseAttendance['realName'] . '</td>
      <td>' . $userCourseAttendance['courseName'] . '</td>
      <td>' . $userCourseAttendance['courseStartDate'] . '</td>
      <td>' . $userCourseAttendance['courseEndDate'] . '</td>
    </tr>';
  }
} else {
  echo '<tr>
          <td colspan="4">This user has not attended any courses.</td>
        </tr>';
}
echo '
  </table>
  <br/>';
//save to Excel
//if($saveExcel == true) {
    require_once '../functions/PHPExcel.php';
    $objPHPExcel = new PHPExcel();
    
    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
    // Set properties
    $objPHPExcel->getProperties()->setCreator("BPeSA reporting System")
                                 ->setLastModifiedBy("System")
                                 ->setTitle("BPeSA") //perhaps add date range here
                                 ->setSubject("BPeSA User Course List")
                                 ->setDescription("A list of users on th BPeSA Skills Portal")
                                 ->setKeywords("User List")
                                 ->setCategory("User List");
  
    //first, insert the record count
    $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'RecordCount');
                

    //set headings

    $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A2', 'User Name')
                ->setCellValue('B2', 'Course Attended')
                ->setCellValue('C2', 'From')
                ->setCellValue('D2', 'Until');
 
    //begin to loop through the Users Object
    $count = 3;
    $counter = 0;

    foreach($userCourseAttendances as $userCourseAttendance) {
      $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $count, $userCourseAttendance['realName']); 	
      $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $count, $userCourseAttendance['courseName']);
      $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $count, $userCourseAttendance['courseStartDate']);
      $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $count, $userCourseAttendance['courseEndDate']);
      $count++;
      $counter++;
    }
    $objPHPExcel->getActiveSheet()->setTitle('CPD Report');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', $counter);
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
//$objWriter->save(HOSTNAME . 'reports/temp_reports/excelReport.xls');
$objWriter->save('../reports/temp_reports/usreCourseList.xls');

echo '
  <br />
  <a href="' . HOSTNAME . 'reports/temp_reports/usreCourseList.xls">Click to download this report.</a>
  <br /><br />
  <a href="reports_user_attendance_list.php"><strong>Back</strong></a>
  <br/>
  <br/>';
  
include '../footer.php';
?>

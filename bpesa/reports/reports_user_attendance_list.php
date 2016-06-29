<?php
//turn off deprecicated warnings
error_reporting(E_ALL ^ E_DEPRECATED);
$page_title = 'BpeSA skills Portal - Report user list';
require_once '../config.php';
require_once '../header.php';

$userAttendedCoursesSql = 'SELECT 
                           id,
                           realName,
                           active
                           FROM users';

$userAttendedCourses = $dbconnect->fetch($userAttendedCoursesSql);
echo '
<h1 class="page-title"><span class="current-page">Prov</span>iders and course list</h1>
<br />
<table class="table1">
  <th>User Name</th>
  <th>Status</th>
  <th>Courses</th>';

if(!empty($userAttendedCourses)) {  
  foreach($userAttendedCourses as $userAttendedCourse) {
    echo '
    <tr>
      <td>' . $userAttendedCourse['realName'] . '</td>
      <td>' . $userAttendedCourse['active'] . '</td>
      <td><a href="' . HOSTNAME . 'reports/reports_user_attendance.php?userId=' . $userAttendedCourse['id'] . '">View Course List</a></td>
    </tr>';
  }
} else {
  echo '
  <tr>
    <td colspan="3">There are no users listed</td>
  </tr>';
} 
echo '</table>
      <br />
      <a href="' . HOSTNAME . 'admin/admin_reports.php"><strong>Back</strong></a>
      <br />
      <br />';

/*Not needed as the list is the same as the user list
//save to Excel
//if($saveExcel == true) {
    require_once '../functions/PHPExcel.php';
    $objPHPExcel = new PHPExcel();
    
    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);

    // Set properties
    $objPHPExcel->getProperties()->setCreator("BPeSA reporting System")
                                 ->setLastModifiedBy("System")
                                 ->setTitle("BPeSA") //perhaps add date range here
                                 ->setSubject("BPeSA User Attendance List")
                                 ->setDescription("A list of users on th BPeSA Skills Portal")
                                 ->setKeywords("User List")
                                 ->setCategory("User List");
  
    //first, insert the record count
    $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'RecordCount');
                

    //set headings

    $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A2', 'User Name')
                ->setCellValue('B2', 'User Type')
                ->setCellValue('C2', 'Company')
                ->setCellValue('D2', 'Email Address');
    //begin to loop through the Users Object
    $count = 3;
    $counter = 0;

    foreach($userAttendedCourses as $userAttendedCourse) {
      $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $count, $userAttendedCourse['realName']); 	
      $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $count, $userAttendedCourse['active']); 
      $count++;
      $counter++;
    }
    $objPHPExcel->getActiveSheet()->setTitle('CPD Report');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', $counter);
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
//$objWriter->save(HOSTNAME . 'reports/temp_reports/excelReport.xls');
$objWriter->save('c:/xampp/htdocs/BPeSA_production/reports/temp_reports/user_attendance.xls');

echo '
  <br />
  <a href="' . HOSTNAME . 'reports/temp_reports/user_attendance.xls">Click to download this report.</a>';
*/

include '../footer.php';
?>

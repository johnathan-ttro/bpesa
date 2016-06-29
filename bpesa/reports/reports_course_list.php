<?php
//turn off deprecicated warnings
$page_title = 'BpeSA skills Portal - Course List';
error_reporting(E_ALL ^ E_DEPRECATED);
require_once '../config.php';
require_once '../header.php';

$currentpage = basename($_SERVER['PHP_SELF']); 
$currentpage = substr($currentpage, 0, -4);

$dbconnect = NEW DB_Class();

if(isset($_POST['datePost'])) {
  if(!empty($_GET['providerId'])) {
    $courseListSql = 'SELECT courses.id, courses.courseName, providers.companyName, courseStartDate, courseEndDate, courses.archived FROM courses
                      INNER JOIN providers
                      ON courses.providerId=providers.userId
                      WHERE providers.userId = ' . $_GET['providerId']  . '
                      AND courses.courseStartDate >= "' . $_POST['dateFrom'] . '" AND courses.courseEndDate <= "' . $_POST['dateTo'] .  '"';
  } else {
    $courseListSql = 'SELECT courses.id, courses.courseName, providers.companyName, courseStartDate, courseEndDate, courses.archived FROM courses
                      INNER JOIN providers
                      ON courses.providerId=providers.userId
                      WHERE courses.courseStartDate >= "' . $_POST['dateFrom'] . '" AND courses.courseEndDate <= "' . $_POST['dateTo'] .  '"';
  } 
} else {
  if(!empty($_GET['providerId'])) {
  $courseListSql = "SELECT courses.id, courses.courseName, providers.companyName, courseStartDate, courseEndDate, courses.archived FROM courses
                    INNER JOIN providers
                    ON courses.providerId=providers.userId
                    WHERE providers.userId = " . $_GET['providerId']  . "";
  } else {
  $courseListSql = "SELECT courses.id, courses.courseName, providers.companyName, courseStartDate, courseEndDate, courses.archived FROM courses
                    INNER JOIN providers
                    ON courses.providerId=providers.userId";
  }
}

$courseLists = $dbconnect->fetch($courseListSql);
echo '
  <h1 class="page-title"><span class="current-page">Cou</span>rse List report</h1>
  <div  class="col-lg-4 col-md-4 col-md-12 col-xs-12">
  <table class="table">
  <form action="reports_course_list.php" method="post">
    <tr>
      <td><label class="text-info">Date From</label></td>
      <td><input type="text" class="form-control" name="dateFrom" id="datepicker"></td>
    </tr>
    <tr>
      <td><label class="text-info">Date Until</label></td>
      <td><input type="text" class="form-control" name="dateTo" id="datepicker2"></td>
   </tr>
   <tr>
     <td><input type="submit" name="datePost" class="btn btn-primary" value="Filter"></td>
     <td></td>
   </tr>
  </form>
  </table>
  </div>
  <table class="table1">
    <th>Course Name</th>
    <th>Dates</th>
    <th>Status</th>';
if(isset($_POST['datePost'])) {	
$arrdateFrom = explode('/', $_POST['dateFrom']);
$dateFrom  = $arrdateFrom[2].'/'.$arrdateFrom[1].'/'.$arrdateFrom[0];

$arrdateTo = explode('/', $_POST['dateTo']);
$dateTo  = $arrdateTo[2].'/'.$arrdateTo[1].'/'.$arrdateTo[0];
}

foreach($courseLists as $courseList){
  
    $arrFromCompare = explode('/', $courseList['courseStartDate']);
    $dateFromCompare  = $arrFromCompare[2].'/'.$arrFromCompare[1].'/'.$arrFromCompare[0];
	
	$arrToCompare = explode('/', $courseList['courseEndDate']);
    $dateToCompare  = $arrToCompare[2].'/'.$arrToCompare[1].'/'.$arrToCompare[0];

if($dateFrom != '' && $dateTo != '') {
  if(($dateFromCompare > $dateFrom-1) && ($dateToCompare < $dateTo+1)) {
      if($courseList['archived']== 'Y') {
      echo '
        <tr>
          <td><a href="' . HOSTNAME . 'admin/admin_view_courses_details.php?courseId=' . $courseList['id'] . '">' . $courseList['courseName'] . ' - by ' . $courseList['companyName'] . '</a></td>
          <td>' . $courseList['courseStartDate'] . ' - ' . $courseList['courseEndDate'] . '</td>
          <td>Expired</td>
        </tr>';   
      } else {
      echo '
        <tr>
          <td><a href="' . HOSTNAME . 'admin/admin_view_courses_details.php?courseId=' . $courseList['id'] . '">' . $courseList['courseName'] . ' - by ' . $courseList['companyName'] . '</a></td>
          <td>' . $courseList['courseStartDate'] . ' - ' . $courseList['courseEndDate'] . '</td>        
          <td>&nbsp;</td>
        </tr>';
     } 
  }
} else {
      if($courseList['archived']== 'Y') {
      echo '
        <tr>
          <td><a href="' . HOSTNAME . 'admin/admin_view_courses_details.php?courseId=' . $courseList['id'] . '">' . $courseList['courseName'] . ' - by ' . $courseList['companyName'] . '</a></td>
          <td>' . $courseList['courseStartDate'] . ' - ' . $courseList['courseEndDate'] . '</td>
          <td>Expired</td>
        </tr>';   
      } else {
      echo '
        <tr>
          <td><a href="' . HOSTNAME . 'admin/admin_view_courses_details.php?courseId=' . $courseList['id'] . '">' . $courseList['courseName'] . ' - by ' . $courseList['companyName'] . '</a></td>
          <td>' . $courseList['courseStartDate'] . ' - ' . $courseList['courseEndDate'] . '</td>        
          <td>&nbsp;</td>
        </tr>';
     } 
}
}
echo '</table>';

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
                                 ->setSubject("BPeSA Course List")
                                 ->setDescription("A list of users on the BPeSA Skills Portal")
                                 ->setKeywords("User List")
                                 ->setCategory("User List");
  
    //first, insert the record count
    $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'RecordCount');
                

    //set headings

    $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A2', 'Course Name')
                ->setCellValue('B2', 'Dates')
                ->setCellValue('C2', 'Expired');
    //begin to loop through the Users Object
    $count = 3;
    $counter = 0;

    foreach($courseLists as $courseList) {
      $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $count, $courseList['courseName']); 	
      $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $count, $courseList['courseStartDate'] . ' - ' . $courseList['courseEndDate']); 
      $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $count, $courseList['archived']);
      $count++;
      $counter++;
    }
    $objPHPExcel->getActiveSheet()->setTitle('CPD Report');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', $counter);
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
//$objWriter->save(HOSTNAME . 'reports/temp_reports/excelReport.xls');
$objWriter->save('../reports/temp_reports/courseList.xls');

echo '
  <br />
  <a href="' . HOSTNAME . 'reports/temp_reports/courseList.xls">Click to download this report.</a><br/>
  <a href="' . HOSTNAME . 'admin/admin_reports.php"><strong>Back</strong></a>
  <br />
  <br />';


include '../footer.php';
?>

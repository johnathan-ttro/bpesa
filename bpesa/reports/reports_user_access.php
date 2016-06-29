<?php
//turn off deprecicated warnings
error_reporting(E_ALL ^ E_DEPRECATED);
$page_title = 'BpeSA skills Portal - Log history';
require_once '../config.php';
require_once '../header.php';

$userAccessListsSql = 'SELECT
                      users.realName,
                      user_log.loggedInDate
                      FROM users
                      INNER JOIN user_log ON users.id = user_log.userId
                      WHERE users.id = ' . $_GET['userId'] .'
					  ORDER BY user_log.loggedInDate';

$userAccessLists = $dbconnect->fetch($userAccessListsSql);

echo '
<h1 class="page-title"><span class="current-page">Log</span> history</h1>
  <table class="table1">
    <th>User Name</th>
    <th>Log In Times</th>';
    foreach($userAccessLists as $userAccessList) {
      echo '
        <tr>
          <td>' . $userAccessList['realName'] . '</td>
          <td>' . $userAccessList['loggedInDate'] . '</td>
        </tr>';
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
                                 ->setSubject("BPeSA User Access List")
                                 ->setDescription("A list of users on th BPeSA Skills Portal")
                                 ->setKeywords("User List")
                                 ->setCategory("User List");
  
    //first, insert the record count
    $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'RecordCount');
                

    //set headings

    $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A2', 'User Name')
                ->setCellValue('B2', 'Access Date');

    //begin to loop through the Users Object
    $count = 3;
    $counter = 0;

    foreach($userAccessLists as $userAccessList) {
      $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $count, $userAccessList['realName']); 	
      $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $count, $userAccessList['loggedInDate']); 
      $count++;
      $counter++;
    }
    $objPHPExcel->getActiveSheet()->setTitle('CPD Report');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', $counter);
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
//$objWriter->save(HOSTNAME . 'reports/temp_reports/excelReport.xls');
$objWriter->save('c:/xampp/htdocs/BPeSA/reports/temp_reports/userAccessList.xls');

echo '
  <br />
  <a href="' . HOSTNAME . 'reports/temp_reports/userAccessList.xls">Click to download this report.</a>
  <br />
  <a href="reports_user_list.php">Back</a>
  <br />';

include '../footer.php'
?>
